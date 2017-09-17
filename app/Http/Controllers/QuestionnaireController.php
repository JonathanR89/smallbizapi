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

class QuestionnaireController extends Controller
{
    use Airtable;

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

    public function saveSubmissionScores(Request $request)
    {
        // dd($request->all());
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

        UserSubmission::where(["submission_id" => $submission_id, "id" => $user_id])->update([
          "price" =>  $price,
          "industry" =>  $industry,
          "comments" =>  $comments,
          "total_users" =>  $total_users,
          "price_range_id" =>  $priceRangeID,
          "industry_id" =>  $industryID,
          "user_size_id" =>  $userSizeID,
        ]);


        $donePreviously =  DB::table('submissions_metrics')->where(["submission_id" => $submission_id])->get();

        if (collect($donePreviously)->isEmpty()) {
            foreach ($answeredQuestions as $submission) {
                if ($submission != null) {
                    $alreadyscored = DB::table('submissions_metrics')->where(["submission_id" => $submission_id, "metric_id" => $submission['id']])->get();
                    if ($alreadyscored->isEmpty()) {
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
                        // dd($test);
                    }
                }
            }
        }
        $db = DB::connection()->getPdo();

        $donePreviously =  DB::table('submissions_packages')->where(["submission_id" => $submission_id])->get();
        // dd(collect($donePreviously)->isEmpty());
        if (collect($donePreviously)->isEmpty()) {
            $sql = 'INSERT INTO submissions_packages (submission_id, package_id, score, created) SELECT submissions.id, packages.id, SUM(submissions_metrics.score * packages_metrics.score)
            AS score, UNIX_TIMESTAMP() FROM submissions INNER JOIN submissions_metrics ON submissions.id = submissions_metrics.submission_id INNER JOIN metrics ON submissions_metrics.metric_id = metrics.id
            INNER JOIN packages_metrics ON metrics.id = packages_metrics.metric_id INNER JOIN packages ON packages_metrics.package_id = packages.id WHERE submissions.id = ? GROUP BY packages.id HAVING score > 0';
            $stmt = $db->prepare($sql);
            $stmt->execute([$submission_id]);
        }
        $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages INNER JOIN packages ON submissions_packages.package_id = packages.id WHERE submissions_packages.submission_id = ? ORDER BY score DESC';
        $stmt = $db->prepare($sql);
        $packages = $stmt->execute([$submission_id]);
        $resultsKey = md5($submission_id . $_SERVER['REMOTE_ADDR'] . 'qqfoo');

        $sql = 'SELECT * FROM submissions WHERE MD5(CONCAT(id, ip, "qqfoo")) = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$resultsKey]);
        $submission = $stmt->fetchObject();

        $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages INNER JOIN packages ON submissions_packages.package_id = packages.id WHERE submissions_packages.submission_id = ? ORDER BY score DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([$submission_id]);
        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages INNER JOIN packages ON submissions_packages.package_id = packages.id WHERE submissions_packages.submission_id = ? ORDER BY score DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([$submission_id]);

        $sql = 'DELETE FROM submissions_packages WHERE submission_id = ? AND package_id = ?';
        $remove = $db->prepare($sql);

        $sql = 'REPLACE INTO submissions_packages SET submission_id = ?, package_id = ?, score = ?, created = UNIX_TIMESTAMP()';
        $insert = $db->prepare($sql);

        // $airtable = Airtable::getData();
        $vendors = Package::all();
        $sponsored = [];
        // dd($industry);
        if ($industryID) {
            foreach ($vendors as $vendor) {
                // dd($vendor);
                // dd($vendor);
                if (isset($vendor->industry_id) && $vendor->industry_id == $industryID) {
                    $insert->execute([$submission_id, $vendor->id, -1]);
                    $sponsored[] = $vendor->id;
                }
            }
        }

        // dd($priceRangeID);
        if ($priceRangeID) {
            //Filter by price
          foreach ($results as $result) {
              // Skip if already sponsored.
            // dd($result);
            // dd($result);
            // dd($result->id, $sponsored);
              if (in_array($result->id, $sponsored)) {
                  continue;
              }

              $entry = null;
              foreach ($vendors as $vendor) {
                  if ($vendor->name == $result->name) {
                      // dd($result);
                $entry = $vendor;
                      break;
                  }
              }
              if (!$entry) {
                  echo 'Removing ' . $result->name . ' because it doesn\'t have Airtable data.<br />';
                  $remove->execute([$submission_id, $result->id]);
              } else {
                  if (isset($entry->price_id)) {
                      $packagePrice = $entry->price_id;
                  }
              // if (isset($entry->{'Price Bands'})) {
              //     $packagePrice .= '-' . $entry->{'Price Bands'};
              // }
              // dd($packagePrice);
              if (isset($packagePrice)) {
                  if ($priceRangeID != $packagePrice) {
                      echo 'Removing ' . $result->name . ' because ' . $packagePrice . ' != ' . $priceRangeID . '<br />';
                      $remove->execute([$submission_id, $result->id]);
                  }
              }
              }
          }
        }

        if ($industryID) {
            // Filter by industry
          foreach ($results as $result) {
              // Skip if already sponsored.
              // dd($sponsored);
              if (in_array($result->id, $sponsored)) {
                  continue;
              }

              $entry = null;
              foreach ($vendors as $vendor) {
                  if ($vendor->id == $result->id) {
                      $entry = $vendor;
                      break;
                  }
              }
              // dd($entry);
              if (!$entry) {
                  echo 'Removing ' . $result->name . ' because it doesn\'t have Airtable data.<br />';
                  $remove->execute([$submission_id, $result->id]);
              } elseif (isset($entry->industry_id) && $entry->industry_id != $industryID) {
                  // dd($industryID);
                  echo 'Removing ' . $result->name . ' because ' . $entry->industry_id .
                   ' != ' . $industry . ' id = ' . $industryID . '<br />';

                  $remove->execute([$submission_id, $result->id]);
              }
          }
        }

        $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages INNER JOIN packages ON submissions_packages.package_id = packages.id WHERE submissions_packages.submission_id = ? ORDER BY FIELD(score, -1, score), score DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([$submission_id]);
        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $max  = 0;
        $rows = [];
        $i = 1;
        // dd($results);
        foreach ($results as $row) {
            if ($row->is_available != 1) {
                $rows[] = $row;
                $max = max($max, intval($row->score));
                $i++;
            }
            var_dump($i);
            if ($i < 5) {
                continue;
            } elseif ($i > 5) {
                break;
            }
        }
        $results = [];
        foreach ($rows as $row) {
            foreach ($vendors as $vendor) {
                if ($vendor->id == $row->id) {
                    $results[] = [
                      "airtableData" => $vendor,
                      "data" => $row,
                    ];
                    $score =  max($max, intval($row->score));
                    // if ($score >= 100) {
                    //     $score = 100;
                    // }
                    // dd($score);
                    UserResult::create([
                      "submission_id" => $submission_id,
                      "user_id" => $user_id,
                      "package_name" => $row->name,
                      "package_id" => $row->id,
                      "score" => $score,
                    ]);
                }
            }
        }
        // if
        return json_encode($results);
    }

    public function saveSubmissionUser(Request $request)
    {
        $lastID =  DB::table('submissions')->insertGetId([
            "ip" => $_SERVER['REMOTE_ADDR'],
            "created" => time()
          ]);
        return "$lastID";
    }

    public function saveSubmissionUserDetails(Request $request)
    {
        $user =  UserSubmission::create($request->all());
        return ['user_id' => $user->id];
    }

    public function saveSubmissionUserResults(Request $result)
    {
        UserResult::create($request->all());
        return 'saved';
    }

    public function getUserResults($submissionID)
    {
        $rows = UserResult::where('submission_id', $submissionID)->get();

        $vendors = Package::all();

        $results = [];
        foreach ($rows as $row) {
            foreach ($vendors as $vendor) {
                if ($vendor->id == $row->package_id) {
                    $SubmissionsPackage = SubmissionsPackage::where(['submission_id' => $submissionID, 'package_id' =>  $row->package_id])->get();
                    $imagePath = null;
                    if (isset($vendor->image_id)) {
                        $image = ImageUploadModel::find($vendor->image_id);
                        $imagePath = url($image->original_filedir);
                    } else {
                        $imagePath = url('uploads/images/clear1.png');
                    }
                    if (count($results) == 5) {
                        break;
                    }
                    $results[] = [
                      "data" => Package::where("id", $row->package_id)->get()->toArray(),
                      "score" => $SubmissionsPackage,
                      "logo_url" => $imagePath,
                    ];
                }
            }
        }
        // dd(count($results));
        return json_encode($results);
    }
}
