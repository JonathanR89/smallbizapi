<?php

namespace App\Http\Controllers;

use DB;
use App\PackageMetric;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        ini_set("max_execution_time", 10000);
        $this->middleware('auth');
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
        PackageMetric::where(['metric_id' => $metricID, 'package_id' => $packageID])->update(['score' => $score]);
        // DB::table('packages_metrics')->where(['metric_id' => $metricID, 'package_id' => $packageID])->update(['score' => $score]);
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
        // \Excel::create('Package Scores', function ($excel) use ($user) {
        //     $excel->setTitle('Package Scores');
        //     $excel->setCreator($user)
        //       ->setCompany('Small Biz CRM');
        //
        //     $excel->setDescription('A demonstration to change the file properties');
        //     $excel->sheet('SB', function ($sheet) {
        //         $packageMetrics = \App\PackageMetric::all();
        //         $packages = \App\Package::orderBy('name')->get();
        //         $metrics = \App\Metric::orderBy('name')->get();
        //
        //         $data = [];
        //
        //         foreach ($packages as $package) {


        
        //           $data[] =
        //
        //           foreach ($variable as $key => $value) {
        //
        //           }
        //         }
        //         $sheet->fromArray($data);
        //     });
        // })->export('xls');
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
