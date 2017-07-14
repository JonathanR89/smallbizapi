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

        $submission_id = $request->input('submissionID');
        $updatedUserID = UserSubmission::where("submission_id", $submission_id)->insertGetId([
          "price" =>  $request->input('selectedPriceRange'),
          "industry" =>  $request->input('selectedIndustry'),
          "comments" =>  $request->input('additionalComments'),
          "total_users" =>  $request->input('selectedUserSize'),
        ]);
        // dd($updatedUserID);
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

        // dd($resultsKey);
        $sql = 'SELECT * FROM submissions WHERE MD5(CONCAT(id, ip, "qqfoo")) = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$resultsKey]);
        $submission = $stmt->fetchObject();

        $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages INNER JOIN packages ON submissions_packages.package_id = packages.id WHERE submissions_packages.submission_id = ? ORDER BY score DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([$submission_id]);
        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);

        // Fetch Airtable data
        $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages INNER JOIN packages ON submissions_packages.package_id = packages.id WHERE submissions_packages.submission_id = ? ORDER BY FIELD(score, -1, score), score DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([$submission_id]);

        $rows = [];
        $max = 0;
        $i = 1;
        while ($row = $stmt->fetchObject()) {
            if ($row->is_available != 0) {
                $rows[] = $row;
                $max = max($max, $row->score);
                $i++;
            }
            if ($i > 5) {
                break;
            }
        }
        // dd($rows);s
        $airtable = Airtable::getData();
        $results = [];
        foreach ($rows as $row) {
            foreach ($airtable->records as $record) {
                if ($record->fields->CRM == $row->name) {
                    // dd($row);
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
