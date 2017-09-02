<?php

namespace App\Console\Commands;

use App\Http\Traits\Airtable;
use App\Package;
// use \TANIOS\Airtable\Airtable;
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
        // dd($vendors);
        foreach ($vendors as $key => $vendor) {
            $vendorInDB =  Package::where('name', 'like', $vendor["CRM"])->first();
            // dd($vendorInDB->isNotEmpty());
            // dd($vendors);
            if ($vendorInDB) {
                $vendorInDB->update([
                "visit_website_url" => isset($vendor['Visit Website Button']) ? $vendor['Visit Website Button'] : null,
                "description" => isset($vendor['Description']) ? $vendor['Description'] : null,
                "price" => isset($vendor['Column 14']) ? $vendor['Column 14'] : null,
                "pricing_pm" => isset($vendor['Pricing pm']) ? $vendor['Pricing pm'] : null,
                "industry_suitable_for" => null,
                "speciality" => null,
                "target_market" => null,
                "vendor_email" => isset($vendor['Vendor Email']) ? $vendor['Vendor Email'] : null,
                "test_email" => isset($vendor['vendor_email_testing']) ? $vendor['vendor_email_testing'] : null,
                "email_interested" => null,
                "vertical" => isset($vendor['Vertical']) ? $vendor['Vertical'] : null,
                "has_trial_period" => null,
                "airtable_id" => isset($vendor['airtable_id']) ? $vendor['airtable_id'] : null,
              ]);
            } else {
            }
        }
    }
}
