<?php

namespace App\Listeners;

use DB;
use App\Events\VendorRefferalSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogVendorReferral
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VendorRefferal  $event
     * @return void
     */
    public function handle($submissionData)
    {
        // dd($submissionData->AirtableData);
        $user = $submissionData->submissionData;
        // dd($submissionData);
        $package = DB::table('packages')->where('name', 'like', $submissionData->vendor->name)->first();
        // dd($package);
        DB::table('vendor_refferals')->insert([
          "submission_id" => $user->submission_id,
          "user_id" => $user->id,
          "package_name" => $package->name,
          "package_id" => $package->id,
          // "airtable_vendor_id" => $vendor->
      ]);
    }
}
