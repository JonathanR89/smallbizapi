<?php

namespace App\Console\Commands;

use App\Http\Traits\Airtable;
use App\Package;
// use \TANIOS\Airtable\Airtable;
use Illuminate\Console\Command;
use App\Http\Traits\AirtableConsultantsTrait;

class SyncStagingEmailsToTest extends Command
{
    use AirtableConsultantsTrait;


    protected $signature = 'staging:setUserEmails';

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
        $vendorInDB =  Package::all();
        foreach ($vendorInDB as $key => $vendor) {
            $vendor =  Package::find($vendor->id)->update([
              'vendor_email' => "devin@smallbizcrm.com, perry@smallbizcrm.com, theresa@smallbizcrm.com, jonathan@smallbizcrm.com"
            ]);
        }
    }
}
