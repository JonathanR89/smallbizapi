<?php

namespace App\Http\Controllers;

use DB;
use App\Metric;
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
        $answeredQuestions = collect($request->input('scores'))->flatten(1);

        $submission_id = $request->input('submissionID');

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
        $stmt->execute([$submission->id]);
        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);

        // Fetch Airtable data
        $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages INNER JOIN packages ON submissions_packages.package_id = packages.id WHERE submissions_packages.submission_id = ? ORDER BY FIELD(score, -1, score), score DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([$submission_id]);

        $rows = [];
        $max = 0;
        $i = 1;
        while ($row = $stmt->fetchObject()) {
            // dd($stmt->fetchObject());
            if ($row->is_available != 1) {
                $rows[] = $row;
                $max = max($max, $row->score);
                $i++;
            }
            if ($i > 5) {
                break;
            }
        }

        $airtable = Airtable::getData();
        // dd($airtable);
        $results = [];
        foreach ($rows as $row) {
            foreach ($airtable->records as $record) {
                if ($record->fields->CRM == $row->name) {
                    $results[] = $record->fields;
                }
            }
        }
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

    public function saveSubmissionUserResults($result)
    {
        UserResult::create($request->all());
    }

    // public function neilsway($category)
    // {
    //     $db = DB::connection()->getPdo();
    //
    //
    //     $progress['category'] = 7;
    //     $sql = 'SELECT * FROM categories WHERE id > ? ORDER BY id LIMIT 1';
    //     $stmt = $db->prepare($sql);
    //     $stmt->execute([$progress['category']]);
    //     $category = $stmt->fetchObject();
    //
    //     if (!$category) {
    //         $sql = 'INSERT INTO submissions (ip, created) VALUES (?, UNIX_TIMESTAMP())';
    //         $stmt = $db->prepare($sql);
    //         $stmt->execute([$_SERVER['REMOTE_ADDR']]);
    //         $id = $db->lastInsertId();
    //
    //         $sql = 'SELECT * FROM submissions WHERE id = ?';
    //         $stmt = $db->prepare($sql);
    //         $stmt->execute([$id]);
    //         $submission = $stmt->fetchObject();
    //
    //         $sql = 'INSERT INTO submissions_metrics (submission_id, metric_id, score, created) VALUES (?, ?, ?, UNIX_TIMESTAMP())';
    //         $stmt = $db->prepare($sql);
    //         foreach ($progress['answers'] as $metric => $score) {
    //             $stmt->execute([$submission->id, $metric, $score]);
    //         }
    //
    //         $sql = 'INSERT INTO submissions_packages (submission_id, package_id, score, created) SELECT submissions.id, packages.id, SUM(submissions_metrics.score * packages_metrics.score) AS score, UNIX_TIMESTAMP() FROM submissions INNER JOIN submissions_metrics ON submissions.id = submissions_metrics.submission_id INNER JOIN metrics ON submissions_metrics.metric_id = metrics.id INNER JOIN packages_metrics ON metrics.id = packages_metrics.metric_id INNER JOIN packages ON packages_metrics.package_id = packages.id WHERE submissions.id = ? GROUP BY packages.id HAVING score > 0';
    //         $stmt = $db->prepare($sql);
    //         $stmt->execute([$submission->id]);
    //
    //         $sql = 'SELECT packages.*, submissions_packages.score FROM submissions_packages INNER JOIN packages ON submissions_packages.package_id = packages.id WHERE submissions_packages.submission_id = ? ORDER BY score DESC';
    //         $stmt = $db->prepare($sql);
    //         $stmt->execute([$submission->id]);
    //
    //         $_SESSION['progress'] = null;
    //         $_SESSION['results_key'] = md5($submission->id . $submission->ip . 'qqfoo');
    //         session_write_close();
    //
    //       // header('Location: submit.php');
    //       exit;
    //     }
    //
    //     $sql = 'SELECT COUNT(1) AS cnt FROM categories';
    //     $stmt = $db->prepare($sql);
    //     $stmt->execute();
    //     $categoryCount = intval($stmt->fetchObject()->cnt);
    //
    //     $sql = 'SELECT COUNT(1) AS cnt FROM categories WHERE id < ?';
    //     $stmt = $db->prepare($sql);
    //     $stmt->execute([$category->id]);
    //     $previousCount = intval($stmt->fetchObject()->cnt);
    //     $progressPercent = ceil(($previousCount + 1)/ $categoryCount * 100);
    //
    //     $sql = 'SELECT id FROM categories WHERE id < ? ORDER BY id DESC LIMIT 1, 1';
    //     $stmt = $db->prepare($sql);
    //     $stmt->execute([$category->id]);
    //     $previous = null;
    //     if ($row = $stmt->fetchObject()) {
    //         $previous = $row->id;
    //     }
    //
    //     $sql = 'SELECT * FROM metrics WHERE category_id = ? ORDER BY id';
    //     $stmt = $db->prepare($sql);
    //     $stmt->execute([$category->id]);
    //     // $row = $stmt->fetchObject();
    //     $rows = [];
    //     while ($row = $stmt->fetchObject()) {
    //         $rows[] = json_encode($row);
    //     }
    //     return $rows;
    // }
}
