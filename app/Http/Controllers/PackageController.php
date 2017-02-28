<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        ini_set("max_execution_time", 1000);
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
        // $packageFromDB = \App\Package::where('id', $packageID)->get()->toArray();
        // // dd($packageFromDB);
        $packageFromDB = DB::table('packages')->where(['id' => $packageID])->get();
        foreach ($packageFromDB as $package) {
            if ($package->is_available == null) {
                DB::table('packages')->where(['id' => $packageID])->update(['is_available' => 1]);
            } else {
                DB::table('packages')->where(['id' => $packageID])->update(['is_available' => null]);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateScore(Request $request, $id)
    {
        $metricID = $request->input('metric_id');
        $packageID = $request->input('package_id');
        $score = $request->input('score');

        DB::table('packages_metrics')->where(['metric_id' => $metricID, 'package_id' => $packageID])->update(['score' => $score]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
