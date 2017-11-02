<?php

namespace App\Http\Controllers;

use DB;
use App\Metric;
use App\Package;
use App\Category;
use App\Submission;
use App\UserResult;
use App\UserSubmission;
use App\SubmissionsMetric;
use App\SubmissionsPackage;
use App\SubmissionUserSize;
use App\SubmissionIndustry;
use Illuminate\Http\Request;
use App\SubmissionPriceRange;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\ImageUpload as ImageUploadModel;

use App\Http\Traits\Airtable;

use App\Http\Traits\VendorInfo;

class QuestionnaireController extends Controller
{
    use Airtable, VendorInfo;

    protected $db;

    public function __construct()
    {
        $this->db = DB::connection()->getPdo();
    }


    public function getMetrics(Request $request)
    {
        $category = $request->all();
        $metrics = Metric::where('category_id', $category['category'])->get();

        return $metrics;
    }

    public function getPriceRanges()
    {
        $priceRanges = SubmissionPriceRange::all();
        return $priceRanges;
    }

    public function getIndustries()
    {
        $submissionIndustry = SubmissionIndustry::all();
        return $submissionIndustry;
    }

    public function getSubmissionUserSize()
    {
        $SubmissionUserSize = SubmissionUserSize::all();
        return $SubmissionUserSize;
    }


    public function getCategories($page = null)
    {
        $categorys = Category::paginate(1);
        return $categorys;
    }

    public function scoreHasNotBeenSaved($submission_id, $metric_id)
    {
        return DB::table('submissions_metrics')->where(["submission_id" => $submission_id,  "metric_id" => $metric_id])->get()->isEmpty();
    }

    public function userHasBeenScored($submission_id)
    {
        return DB::table('submissions_metrics')->where(["submission_id" => $submission_id])->get();
    }

    public function updateSubmissionScores(Request $request)
    {
        $submission_id = $request->input('submissionID');
        $user_id = $request->input('user_id');

        UserSubmission::where(["submission_id" => $submission_id, "id" => $user_id])->update([
        "price" =>  $request->input('selectedPriceRange'),
        "price_range_id" =>  $request->input('selectedPriceRangeID'),
        "industry" =>  $request->input('selectedIndustry'),
        "industry_id" =>  $request->input('selectedIndustryID'),
        "comments" =>  $request->input('additionalComments'),
        "total_users" =>  $request->input('selectedUserSize'),
        "user_size_id" =>  $request->input('selectedUserSizeID'),
      ]);
        return true;
    }

    public function handleAnswers($answeredQuestions, $submission_id)
    {
        foreach ($answeredQuestions as $submission) {
            if ($submission != null) {
                if ($this->scoreHasNotBeenSaved($submission_id, $submission['id'])) {
                    $score = isset($submission['score']) ? $submission['score'] : 0;
                    DB::table('submissions_metrics')->insert([
                      "submission_id" => $submission_id,
                      "metric_id" => $submission['id'],
                      "created" => time(),
                      "score" => $score,
                    ]);
                } else {
                    $score = isset($submission['score']) ? $submission['score'] : 0;
                    $test = DB::table('submissions_metrics')->where([
                      "submission_id" => $submission_id,
                      "metric_id" => $submission['id'],
                    ])->update([
                      "score" => $score,
                    ]);
                }
            }
        }
        return true;
    }

    public function getResultsKey($submission_id)
    {
        $sql = 'SELECT packages.*, submissions_packages.score
        FROM submissions_packages
        INNER JOIN packages ON submissions_packages.package_id = packages.id
        WHERE submissions_packages.submission_id = ?
        ORDER BY score DESC';

        $stmt = $this->db->prepare($sql);
        $packages = $stmt->execute([$submission_id]);
        return md5($submission_id . $_SERVER['REMOTE_ADDR'] . 'qqfoo');
    }

    public function getSubmission($resultsKey)
    {
        $sql = 'SELECT * FROM submissions
        WHERE MD5(CONCAT(id, ip, "qqfoo")) = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$resultsKey]);
        return $stmt->fetchObject();
    }

    public function getResults($submission_id, $limit = 0)
    {
        if ($limit > 0) {
            $sql = 'SELECT packages.*, submissions_packages.score
          FROM submissions_packages
          INNER JOIN packages ON submissions_packages.package_id = packages.id
          WHERE submissions_packages.submission_id = ?
          ORDER BY score DESC LIMIT ?';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$submission_id, $limit]);
        } else {
            $sql = 'SELECT packages.*, submissions_packages.score
          FROM submissions_packages
          INNER JOIN packages ON submissions_packages.package_id = packages.id
          WHERE submissions_packages.submission_id = ?
          ORDER BY score DESC';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$submission_id]);
        }
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    public function saveSubmissionScores(Request $request)
    {
        $answeredQuestions = collect($request->input('scores'))->flatten(1);
        $price =  $request->input('selectedPriceRange');
        $priceRangeID =  $request->input('selectedPriceRangeID');
        $industry = $request->input('selectedIndustry');
        $industryID = $request->input('selectedIndustryID');
        $total_users = $request->input('selectedUserSize');
        $userSizeID = $request->input('selectedUserSizeID');
        $comments = $request->input('additionalComments');

        $submission_id = $request->input('submissionID');
        $user_id = $request->input('user_id');

        $this->updateSubmissionScores($request);

        if ($answeredQuestions->isNotEmpty()) {
            $this->handleAnswers($answeredQuestions, $submission_id);
        }

        $db = $this->db;
        $donePreviously =  DB::table('submissions_packages')->where(["submission_id" => $submission_id])->get();
        if (collect($donePreviously)->isEmpty()) {
            $sql = 'INSERT INTO submissions_packages (submission_id, package_id, score, created)
            SELECT submissions.id, packages.id, SUM(submissions_metrics.score * packages_metrics.score)
            AS score, UNIX_TIMESTAMP()
            FROM submissions
            INNER JOIN submissions_metrics ON submissions.id = submissions_metrics.submission_id
            INNER JOIN metrics ON submissions_metrics.metric_id = metrics.id
            INNER JOIN packages_metrics ON metrics.id = packages_metrics.metric_id
            INNER JOIN packages ON packages_metrics.package_id = packages.id
            WHERE submissions.id = ?
            GROUP BY packages.id
            HAVING score > 0';
            $stmt = $db->prepare($sql);
            $stmt->execute([$submission_id]);
        }

        $submission = $this->getSubmission($this->getResultsKey($submission_id));

        $sql = 'SELECT packages.*, submissions_packages.score
        FROM submissions_packages
        INNER JOIN packages
        ON submissions_packages.package_id = packages.id
        WHERE submissions_packages.submission_id = ?
        ORDER BY score DESC';

        $stmt = $db->prepare($sql);
        $packagesScored = $stmt->execute([$submission_id]);
        // dump($packagesScored);
        $sql = 'DELETE FROM submissions_packages WHERE submission_id = ? AND package_id = ?';
        $remove = $db->prepare($sql);

        // dump($results);
        $sql = 'REPLACE INTO submissions_packages SET submission_id = ?, package_id = ?, score = ?, created = UNIX_TIMESTAMP()';
        $insert = $db->prepare($sql);

        $vendors = Package::all();
        $sponsored = [];
        $sponsorCount = 0;

        if ($industryID) {
            # code...
          foreach ($vendors as $vendor) {
              // if ($industryID && $priceRangeID) {
            // matching verticals and price backets
            // if (isset($vendor->price_id)) {
            // if (($vendor->price_id == $priceRangeID) && ($vendor->industry_id == $industryID)) {
            //     if ($sponsorCount <= 2) {
            //         $sponsored[] = $vendor->id;
            //         $sponsorCount++;
            //     }
            // }
              if ($vendor->industry->id == $industryID) {
                  // dump($vendor->industry_id == $industryID);
                  $insert->execute([$submission_id, $vendor->id, -1]);
                  $sponsored[] = $vendor->id;
              # code...
              } else {
                  if ($vendor->industry->id) {
                      $remove->execute([$submission_id, $vendor->id]);
                  }
              }
          }
            // }
            // }
        }



        // $results = $this->getResults($submission_id);

        $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages
        INNER JOIN packages ON submissions_packages.package_id = packages.id
        WHERE submissions_packages.submission_id = ? ORDER BY score DESC';

        $stmt = $db->prepare($sql);
        $stmt->execute([$submission_id]);
        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);

        if ($priceRangeID) {
            foreach ($results as $key => $record) {
                if (in_array($record->id, $sponsored)) {
                    continue;
                }

                $entry = null;
                foreach ($vendors as $vendor) {
                    if ($record->id == $vendor->id) {
                        $entry = $vendor;
                        break;
                    }
                }

                // if (!$entry) {
                //     //                echo 'Removing ' . $result->name . ' because it doesn\'t have Airtable data.<br />';
                //   // $remove->execute([$submission_id, $record->id]);
                // } elseif ($priceRangeID == 1) {
                //     // if (!$entry->price_id == 1) {
                //   //     //                    echo 'Removing ' . $result->name . ' because it isn\'t free.<br />';
                //   // $remove->execute([$submission_id, $record->id]);
                //   // } else {
                //   if ($priceRangeID != $entry->price_id) {
                //       // $remove->execute([$submission_id, $record->id]);
                //   }
                // }

                if ($entry->price_id != $priceRangeID) {
                    $remove->execute([$submission_id, $record->id]);
                }
                if (!$industryID) {
                    if ($entry->industry->id != 26) {
                        $remove->execute([$submission_id, $record->id]);
                    }
                }
            }
        }

        if ($industryID) {
            foreach ($results as $key => $record) {
                if (in_array($record->id, $sponsored)) {
                    // dump($record->id);
                    // dump($record->id, $sponsored);
                    continue;
                }

                $entry = null;
                foreach ($vendors as $vendor) {
                    if ($vendor->id == $record->id) {
                        $entry = $vendor;
                        break;
                    }
                }

                // if (!$entry) {
                //     echo 'Removing ' . $record->name . ' because it doesn\'t have Airtable data.<br />';
                //     $remove->execute([$submission_id, $record->id]);
                if (isset($record->industry_id) && ($record->industry_id != $industryID)) {
                    // $remove->execute([$submission_id, $record->id]);
                }
            }
        }



        // dd($vendor->price_id == $priceRangeID);

        $sql = 'SELECT packages.*, submissions_packages.score
        FROM submissions_packages
        INNER JOIN packages ON submissions_packages.package_id = packages.id
        WHERE submissions_packages.submission_id = ?
        ORDER BY FIELD(score, -1, score), score DESC';

        $stmt = $db->prepare($sql);
        $stmt->execute([$submission_id]);
        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
        // dd($results);

        // foreach ($results as $key => $result) {
        //     $package = Package::find($result->id);
        //     // var_dump($package->industry->id == 26);
        //     if ($package->industry->id != 26) {
        //         $remove->execute([$submission_id, $result->id]);
        //     }
        // }
        //
        // $stmt = $db->prepare($sql);
        // $stmt->execute([$submission_id]);
        // $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
        // dd(count($results));

        $max  = 0;
        $rows = [];
        $i = 0;
        $total = count($results);

        foreach ($results as $row) {
            if (isset($row->is_available)  ||  isset($row['is_available'])) {
                if ($row->is_available != 1) {
                    $rows[] = $row;
                    $i++;
                }
                if ($i == 5) {
                    break;
                }
            }
        }

        $resultsDuplicateCheck = [];
        foreach ($rows as $row) {
            foreach ($vendors as $vendor) {
                if ($vendor->id == $row->id) {
                    $max =  max($max, intval($row->score));
                    $score = $this->getScore($submission_id, $row->id)->toArray();
                    if (!in_array($row->id, $resultsDuplicateCheck)) {
                        UserResult::create([
                        "submission_id" => $submission_id,
                        "user_id" => $user_id,
                        "package_name" => $row->name,
                        "package_id" => $row->id,
                        "score" => isset($score[0]['score']) ? $score[0]['score'] : 0,
                      ]);
                        $resultsDuplicateCheck[] = $row->id;
                    }
                }
            }
        }
        return $this->getUserResults($submission_id);
    }

    public function saveSubmissionUser(Request $request)
    {
        $lastID =  DB::table('submissions')->insertGetId([
            "ip" => $_SERVER['REMOTE_ADDR'],
            "created" => time()
          ]);
        return $lastID;
    }

    public function saveSubmissionUserDetails(Request $request)
    {
        $this->validate($request, [
          "name" => 'required',
          "email" => 'required',
          "submission_id" => 'required'
        ]);

        $user =  UserSubmission::create($request->all());
        return ['user_id' => $user->id];
    }

    public function saveSubmissionUserResults(Request $result)
    {
        UserResult::create($request->all());
        return 'saved';
    }

    public function getScore($submissionID, $package_id)
    {
        $score = SubmissionsPackage::where([
          'submission_id' => $submissionID,
           'package_id' =>  $package_id
           ])->get();
        if ($score->isNotEmpty()) {
            return $score;
        }
        return $score->score = [0 => [ 'score' => 0]];
    }

    public function getUserResults($submissionID)
    {
        $rows = UserResult::where('submission_id', $submissionID)->get();

        $vendors = Package::all();

        $results = [];
        foreach ($rows as $row) {
            foreach ($vendors as $vendor) {
                if ($vendor->id == $row->package_id) {
                    $imagePath = null;
                    if (isset($vendor->image_id)) {
                        $image = ImageUploadModel::find($vendor->image_id);
                        $imagePath = url($image->original_filedir);
                    } else {
                        $imagePath = url('uploads/images/clear1.png');
                    }
                    $results[] = [
                      "data" => Package::where("id", $row->package_id)->get()->toArray(),
                      "score" => $this->getScore($submissionID, $row->package_id),
                      "logo_url" => $imagePath,
                    ];
                }
                if (count($results) >= 5) {
                    // dump(count($results));
                    break;
                }
            }
        }
        return collect($results);
    }
}
