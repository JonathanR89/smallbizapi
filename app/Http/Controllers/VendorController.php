<?php

namespace App\Http\Controllers;

use DB;
use App\PackageMetric;
use App\Http\Traits\Airtable;
use Illuminate\Http\Request;

class VendorController extends Controller
{
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
                // dd($vendorData);
                $vendorsArray[] = $vendorData->fields;
            // $vendorData
            }
            // dd(array_values($vendor));
        }
        // dd($vendorsArray);
        return view('vendors.index', compact("vendorsArray"));
    }

    public function toggleInterested()
    {
      $packageMetrics = \App\PackageMetric::all();
      $packages = \App\Package::orderBy('name')->paginate(10);
      $metrics = \App\Metric::orderBy('name')->get();
      return view('packages.interested', compact("packageMetrics", "packages", "metrics"));
    }
}
