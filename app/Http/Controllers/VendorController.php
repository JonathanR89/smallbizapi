<?php

namespace App\Http\Controllers;

use DB;
use App\PackageMetric;
use Illuminate\Http\Request;
use App\Http\Traits\Airtable;

class VendorController extends Controller
{
    use Airtable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Airtable::getData();
        $vendors = collect($vendors);
        $vendors->take(10);
        $vendors->all();

        $vendorsArray = [];
        foreach ($vendors as $vendor) {
            foreach ($vendor as $vendorData) {
                $vendorsArray[] = $vendorData->fields;
            }
        }
        return view('vendors.index', compact("vendorsArray"));
    }

    public function toggleInterested()
    {
        $packageMetrics = \App\PackageMetric::all();
        $packages = \App\Package::orderBy('name')->paginate(10);
        $metrics = \App\Metric::orderBy('name')->get();
        return view('packages.interested', compact("packageMetrics", "packages", "metrics"));
    }

    public function packageInterested(Request $request)
    {
        $packageID = $request->input('package_id');

        $packageFromDB = DB::table('packages')->where(['id' => $packageID])->get();
        foreach ($packageFromDB as $package) {
            if ($package->interested == 0) {
                DB::table('packages')->where(['id' => $packageID])->update(['interested' => 1]);
            } else {
                DB::table('packages')->where(['id' => $packageID])->update(['interested' => 0]);
            }
        }
    }


    public function searchTable(Request $request)
    {
        $searchTerm = $request->input('search_term');
        $packageMetrics = \App\PackageMetric::all();
        $packages = \App\Package::where('name', 'like', "%$searchTerm%")->paginate(10);
        $metrics = \App\Metric::orderBy('name')->get();
        return view('packages.interested', compact("packageMetrics", "packages", "metrics"));
    }

    public function getTopVendors()
    {
        $data = DB::table('user_results')->select('package_id', DB::raw('COUNT(package_id) AS occurrences'))
           ->groupBy('package_id')
           ->orderBy('occurrences', 'DESC')
           ->get();

        dd($data);
    }
}
