<?php
namespace App\Http\Traits;

use DB;
use App\Package;
use App\PackageMetric;
use App\Http\Traits\Airtable;

trait VendorInfo
{
    public static function getTopVendors($needed = 10)
    {
        $popularPackages = DB::table('user_results')->select('package_id', 'package_name', DB::raw('COUNT(package_id) AS occurrences'))
         ->groupBy('package_id')
         ->orderBy('occurrences', 'DESC')
         ->limit($needed)
         ->get();
        $packages = [];
        foreach ($popularPackages as $key => $id) {
            $packages[] = Package::where('id', $id->package_id)->first();
        }

        return $packages;
    }
}
