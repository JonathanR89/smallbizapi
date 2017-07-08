<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Metric;
use App\Category;
use App\Submission;
use DB;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    public function getMetrics($page = null)
    {
        $metrics = Metric::paginate(5);
        return $metrics;
    }

    public function getCategories($page = null)
    {
        $categorys = Category::all();
        return $categorys;
    }

    public function saveSubmissionScores(Request $request)
    {
        // dd("here");
        $submissionID = \Session::get('submission_uid');
        // dd($submissionID);
      //   foreach ($request->input('scores') as $submission) {
      //       $saved =  DB::table('submissions_metrics')->insert([
      //       "submission_id" => $lastID,
      //       "metric_id" => $submission['id'],
      //       "score" => $submission['score'] ?? 0,
      //       "created" => time(),
      // ]);
      //   }
      //
      //   DB::table('submissions_packages')->insert([
      //   "submission_id" => $submissionID,
      //   "package_id" => $submission['id'],
      //   "score" => $submission['score'] ?? 0,
      //   "created" => time(),
      // ]);
    }

    public function saveSubmissionUser(Request $request)
    {
        $lastID =  DB::table('submissions')->insertGetId([
            "ip" => $_SERVER['REMOTE_ADDR'],
            "created" => time()
          ]);

        \Session::put('submission_uid', $lastID);
        dd($lastID);
        return $lastID;
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
