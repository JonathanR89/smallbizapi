<?php

namespace App\Http\Controllers;

use App\PackageMetric;
use DB;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    protected $db;

    public function __construct()
    {
        ini_set("max_execution_time", 10000);
        $this->middleware('auth');
        $this->db = DB::connection()->getPdo();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packageMetrics = \App\PackageMetric::all();
        $packages = \App\Package::orderBy('name')->paginate(10);
        $metrics = \App\Metric::orderBy('name')->get();
        return view('packages.index', compact("packageMetrics", "packages", "metrics"));
    }

    public function packageAvailability(Request $request)
    {
        $packageID = $request->input('package_id');

        $packageFromDB = DB::table('packages')->where(['id' => $packageID])->get();
        foreach ($packageFromDB as $package) {
            if ($package->is_available == 0) {
                DB::table('packages')->where(['id' => $packageID])->update(['is_available' => 1]);
            } else {
                DB::table('packages')->where(['id' => $packageID])->update(['is_available' => 0]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateScore(Request $request)
    {
        $metricID = $request->input('metric_id');
        $packageID = $request->input('package_id');
        $score = $request->input('score');
        $score = max(0, $score);
        $score = min(5, $score);
        $sql = 'INSERT INTO packages_metrics (package_id, metric_id, score, created)
        VALUES (?, ?, ?, UNIX_TIMESTAMP())
        ON DUPLICATE KEY
        UPDATE score = ?, modified = UNIX_TIMESTAMP()';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$packageID, $metricID, $score, $score]);
        return $this->db->lastInsertId();
    }

    public function searchTable(Request $request)
    {
        $searchTerm = $request->input('search_term');
        $packageMetrics = \App\PackageMetric::all();
        $packages = \App\Package::where('name', 'like', "%$searchTerm%")->paginate(10);
        $metrics = \App\Metric::orderBy('name')->get();
        return view('packages.index', compact("packageMetrics", "packages", "metrics"));
    }

    public function exportCSV()
    {
        $user = \Auth::user()->name;
        $packageMetrics = \App\PackageMetric::all();
        $packages = \App\Package::where('name')->paginate(10);
        $metrics = \App\Metric::orderBy('name')->get();

        // return view('packages.index', compact("packageMetrics", "packages", "metrics"));

        \Excel::create('Export Package Scores', function ($excel) {
            $excel->sheet('First sheet', function ($sheet) {
                $packageMetrics = \App\PackageMetric::all();
                $packages = \App\Package::where('name')->paginate(10);
                $metrics = \App\Metric::orderBy('name')->get();

                $sheet->loadView('packages.index', compact("packageMetrics", "packages", "metrics"));
                // $sheet->loadView('packages.index', array('packageMetrics' => $packageMetrics, ));
            });
        })->export('csv');

        return view('packages.index', compact("packageMetrics", "packages", "metrics"));
    }
}
