<?php

namespace App\Console\Commands;

use App\Http\Traits\Airtable;
use App\AirtableConsultant;
use \TANIOS\Airtable\Airtable;
use Illuminate\Console\Command;
use App\Http\Traits\AirtableConsultantsTrait;

class SeedVendorsDatabaseFromAirtable extends Command
{
    use AirtableConsultantsTrait;


    protected $signature = 'airtableVendors:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        $airtableVendors = Airtable::getData();
        $vendors = [];
        foreach (collect($airtableVendors)->flatten(1) as $key => $airtableVendor) {
            // dd($airtableVendor);
            $vendor =  $airtableVendor->fields;
            $vendor = collect($vendor)->put('airtable_id', $airtableVendor->id);
            $vendors[] = $vendor;
        }

        foreach ($vendors as $key => $vendor) {
            $vendorInDB =  AirtableConsultant::find($vendor["airtable_id"]);
            if ($vendorInDB !== null) {
                AirtableConsultant::where('airtable_id', $vendor["airtable_id"])->update([
                  "record_name" => isset($vendor["record_name"]) ? $vendor["record_name"] : null,
                  "company" => isset($vendor["company"]) ? $vendor["company"] : null,
                  "short_description" => isset($vendor["short_description"]) ? $vendor["short_description"] : null,
                  "email" => isset($vendor["email"]) ? $vendor["email"] : null,
                  "country" => isset($vendor["country"]) ? $vendor["country"] : null,
                  "state_province" => isset($vendor["state_province"]) ? $vendor["state_province"] : null,
                  "town" => isset($vendor["town"]) ? $vendor["town"] : null,
                  "pricing_pm" => isset($vendor["pricing_pm"]) ? $vendor["pricing_pm"] : null,
                  "industry_suitable_for" => isset($vendor["industry_suitable_for"]) ? $vendor["industry_suitable_for"] : null,
                  "speciality" => isset($vendor["speciality"]) ? $vendor["speciality"] : null,
                  "target_market" => isset($vendor["target_market"]) ? $vendor["target_market"] : null,
                  "url" => isset($vendor["url"]) ? $vendor["url"] : null,
                  "test_email" => isset($vendor["test_email"]) ? $vendor["test_email"] : null,
                  "description" => isset($vendor["description"]) ? $vendor["description"] : null,
                  "email_interested" => isset($vendor["email_interested"]) ? $vendor["email_interested"] : null,
            ]);
            } else {
                AirtableConsultant::create([
                  "airtable_id" => $vendor["airtable_id"],
                  "record_name" => isset($vendor["record_name"]) ? $vendor["record_name"] : null,
                  "company" => isset($vendor["company"]) ? $vendor["company"] : null,
                  "short_description" => isset($vendor["short_description"]) ? $vendor["short_description"] : null,
                  "email" => isset($vendor["email"]) ? $vendor["email"] : null,
                  "country" => isset($vendor["country"]) ? $vendor["country"] : null,
                  "state_province" => isset($vendor["state_province"]) ? $vendor["state_province"] : null,
                  "town" => isset($vendor["town"]) ? $vendor["town"] : null,
                  "pricing_pm" => isset($vendor["pricing_pm"]) ? $vendor["pricing_pm"] : null,
                  "industry_suitable_for" => isset($vendor["industry_suitable_for"]) ? $vendor["industry_suitable_for"] : null,
                  "speciality" => isset($vendor["speciality"]) ? $vendor["speciality"] : null,
                  "target_market" => isset($vendor["target_market"]) ? $vendor["target_market"] : null,
                  "url" => isset($vendor["url"]) ? $vendor["url"] : null,
                  "test_email" => isset($vendor["test_email"]) ? $vendor["test_email"] : null,
                  "description" => isset($vendor["description"]) ? $vendor["description"] : null,
                  "email_interested" => isset($vendor["email_interested"]) ? $vendor["email_interested"] : null,
          ]);
            }
        }
    }
}
