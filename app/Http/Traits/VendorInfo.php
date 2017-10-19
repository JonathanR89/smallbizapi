<?php
namespace App\Http\Traits;

use DB;
use App\Package;
use App\PackageMetric;
use App\Http\Traits\Airtable;

trait VendorInfo
{
    public static function getTopVendors()
    {
        $popularPackages = DB::table('user_results')->select('package_id', 'package_name', DB::raw('COUNT(package_id) AS occurrences'))
         ->groupBy('package_id')
         ->orderBy('occurrences', 'DESC')
         ->limit(10)
         ->get();
        $packages = [];
        foreach ($popularPackages as $key => $id) {
            $packages[] = Package::where('id', $id->package_id)->first();
          // $packages[] = $package->put('occurrences', $id->occurrences)->toArray();
        }
        $airtable = Airtable::getData();
        $results = [];
        foreach ($packages as  $row) {
            foreach ($airtable->records as $record) {
                if ($record->fields->CRM == $row->name) {
                    $results[] = [
                    "airtableData" => $record->fields,
                    "data" => $row,
                  ];
                }
            }
        }
        return $results;
    }
}
