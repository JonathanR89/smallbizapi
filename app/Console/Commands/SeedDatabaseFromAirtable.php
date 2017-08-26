<?php

namespace App\Console\Commands;

use App\AirtableConsultant;
use \TANIOS\Airtable\Airtable;
use Illuminate\Console\Command;
use App\Http\Traits\AirtableConsultantsTrait;

class SeedDatabaseFromAirtable extends Command
{
    use AirtableConsultantsTrait;


    protected $signature = 'airtable:seed';

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
        $airtableConsultants = AirtableConsultantsTrait::getData();
        $consultants = [];
        foreach (collect($airtableConsultants)->flatten(1) as $key => $airtableConsultant) {
            // dd($airtableConsultant);
            $consultant =  $airtableConsultant->fields;
            $consultant = collect($consultant)->put('airtable_id', $airtableConsultant->id);
            $consultants[] = $consultant;
        }
        foreach ($consultants as $key => $consultant) {
            // dd($consultant["airtable_id"]);
            AirtableConsultant::firstOrCreate([
              "airtable_id" => $consultant["airtable_id"],
              "record_name" => isset($consultant["record_name"]) ? $consultant["record_name"] : null,
              "company" => isset($consultant["company"]) ? $consultant["company"] : null,
              "short_description" => isset($consultant["short_description"]) ? $consultant["short_description"] : null,
              "email" => isset($consultant["email"]) ? $consultant["email"] : null,
              "country" => isset($consultant["country"]) ? $consultant["country"] : null,
              "state_province" => isset($consultant["state_province"]) ? $consultant["state_province"] : null,
              "town" => isset($consultant["town"]) ? $consultant["town"] : null,
              "pricing_pm" => isset($consultant["pricing_pm"]) ? $consultant["pricing_pm"] : null,
              "industry_suitable_for" => isset($consultant["industry_suitable_for"]) ? $consultant["industry_suitable_for"] : null,
              "speciality" => isset($consultant["speciality"]) ? $consultant["speciality"] : null,
              "target_market" => isset($consultant["target_market"]) ? $consultant["target_market"] : null,
              "url" => isset($consultant["url"]) ? $consultant["url"] : null,
              "test_email" => isset($consultant["test_email"]) ? $consultant["test_email"] : null,
              "description" => isset($consultant["description"]) ? $consultant["description"] : null,
              "email_interested" => isset($consultant["email_interested"]) ? $consultant["email_interested"] : null,
            ]);
        }
    }
}
