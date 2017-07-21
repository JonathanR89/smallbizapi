<?php

namespace App\Http\Controllers;

use DB;
use App\Metric;
use App\Package;
use App\Category;
use App\Submission;
use App\UserResult;
use App\UserSubmission;
use App\SubmissionUserSize;
use App\SubmissionIndustry;
use Illuminate\Http\Request;
use App\SubmissionPriceRange;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Traits\Airtable;

class QuestionnaireController extends Controller
{
    use Airtable;

    public function getMetrics(Request $request)
    {
        $metrics = Metric::paginate(5);
        return $metrics;
    }

    public function getPriceRanges()
    {
        $submissionIndustry = SubmissionPriceRange::all();
        return $submissionIndustry;
    }

    public function getIndustries()
    {
        $submissionIndustry = SubmissionIndustry::all();
        return $submissionIndustry;
    }

    public function getSubmissionUserSize()
    {
        $submissionIndustry = SubmissionUserSize::all();
        return $submissionIndustry;
    }


    public function getCategories($page = null)
    {
        $categorys = Category::all();
        return $categorys;
    }

    public function saveSubmissionScores(Request $request)
    {
        // dd($request->all());

        $answeredQuestions = collect($request->input('scores'))->flatten(1);

        $price =  $request->input('selectedPriceRange');
        $industry = $request->input('selectedIndustry');
        $comments = $request->input('comments');
        $total_users = $request->input('selectedUserSize');

        $submission_id = $request->input('submissionID');
        $updatedUserID = UserSubmission::where("submission_id", $submission_id)->insertGetId([
          "price" =>  $price,
          "industry" =>  $industry,
          "comments" =>  $comments,
          "total_users" =>  $total_users,
        ]);
        $donePreviously =  DB::table('submissions_metrics')->where(["submission_id" => $submission_id])->get();

        if (collect($donePreviously)->isEmpty()) {
            foreach ($answeredQuestions as $submission) {
                if ($submission != null) {
                    $saved =  DB::table('submissions_metrics')->insertGetId([
                      "submission_id" => $submission_id,
                      "metric_id" => $submission['id'],
                      "score" => $submission['score'] ?? 0,
                      "created" => time(),
                    ]);
                }
            }
        }
        $db = DB::connection()->getPdo();

        $donePreviously =  DB::table('submissions_packages')->where(["submission_id" => $submission_id])->get();
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

        $sql = 'DELETE FROM submissions_packages WHERE submission_id = ? AND package_id = (SELECT id FROM packages WHERE name = ? LIMIT 1)';
        $remove = $db->prepare($sql);

        $sql = 'REPLACE INTO submissions_packages SET submission_id = ?, package_id = (SELECT id FROM packages WHERE name = ? LIMIT 1), score = ?, created = UNIX_TIMESTAMP()';
        $insert = $db->prepare($sql);

        $airtable = Airtable::getData();

        $sponsored = [];
        if ($industry) {
            foreach ($airtable->records as $record) {
                if (isset($record->fields->Vertical) && strstr($record->fields->Vertical, $industry)) {
                    $insert->execute([$submission_id, $record->fields->CRM, -1]);
                    $sponsored[] = $record->fields->CRM;
                }
            }
        }
        if ($price) {
            //Filter by price
          foreach ($results as $result) {
              // Skip if already sponsored.
            // dd($result);
            if (in_array($result->name, $sponsored)) {
                continue;
            }

              $entry = null;
              foreach ($airtable->records as $record) {
                  if ($record->fields->CRM == $result->name) {
                      // dd($result);
                      $entry = $record->fields;
                      break;
                  }
              }
              if (!$entry) {
                  echo 'Removing ' . $result->name . ' because it doesn\'t have Airtable data.<br />';
                  $remove->execute([$submission_id, $result->name]);
              } elseif ($price == 'Free') {
                  // dd(isset($entry->Free));
                  if (isset($entry->Free)) {
                      echo 'Removing ' . $result->name . ' because it isn\'t free.<br />';
                      $remove->execute([$submission_id, $result->name]);
                  }
              } else {
                  // dd($entry);
                  if (isset($entry->{'Column 14'})) {
                      $packagePrice = $entry->{'Column 14'};
                  }
                  if (isset($entry->{'Price Bands'})) {
                      $packagePrice .= '-' . $entry->{'Price Bands'};
                  }
                  if (isset($packagePrice)) {
                      if ($price != $packagePrice) {
                          echo 'Removing ' . $result->name . ' because ' . $packagePrice . ' != ' . $price . '<br />';
                          $remove->execute([$submission_id, $result->name]);
                      }
                  }
              }
          }
        }

        if ($industry) {
            // Filter by industry
          foreach ($results as $result) {
              // Skip if already sponsored.
            if (in_array($result->name, $sponsored)) {
                continue;
            }

              $entry = null;
              foreach ($airtable->records as $record) {
                  if ($record->fields->CRM == $result->name) {
                      $entry = $record->fields;
                      break;
                  }
              }
              if (!$entry) {
                  echo 'Removing ' . $result->name . ' because it doesn\'t have Airtable data.<br />';
                  $remove->execute([$submission_id, $result->name]);
              } elseif (isset($entry->Vertical) && !strstr($entry->Vertical, $industry)) {
                  echo 'Removing ' . $result->name . ' because ' . $entry->Vertical . ' != ' . $industry . '<br />';
                  $remove->execute([$submission_id, $result->name]);
              }
          }
        }

        $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages INNER JOIN packages ON submissions_packages.package_id = packages.id WHERE submissions_packages.submission_id = ? ORDER BY FIELD(score, -1, score), score DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([$submission_id]);
        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $max = 0;
        $rows = [];
        $i = 1;
        foreach ($results as $row) {
            if ($row->is_available != 1) {
                $rows[] = $row;
                $max = max($max, intval($row->score));
                $i++;
            }
            if ($i > 5) {
                break;
            }
        }
        $results = [];
        foreach ($rows as $row) {
            foreach ($airtable->records as $record) {
                if ($record->fields->CRM == $row->name) {
                    $results[] = [
                      "airtableData" => $record->fields,
                      "data" => $row,
                    ];
                    UserResult::create([
                      "submission_id" => $submission_id,
                      "user_id" => $updatedUserID,
                      "package_name" => $row->name,
                      "package_id" => $row->id,
                    ]);
                }
            }
        }
        // dd($results);
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
        UserSubmission::create($request->all());
    }

    public function saveSubmissionUserResults(Request $result)
    {
        UserResult::create($request->all());
    }

    public function getUserResults($submissionID)
    {
        $rows = UserResult::where('submission_id', $submissionID)->get();

        $airtable = Airtable::getData();
        $results = [];
        foreach ($rows as $row) {
            foreach ($airtable->records as $record) {
                if ($record->fields->CRM == $row->package_name) {
                    $results[] = [
                      "airtableData" => $record->fields,
                      "data" => Package::where("id", $row->package_id)->get(),
                    ];
                }
            }
        }
        return json_encode($results);
    }
}
