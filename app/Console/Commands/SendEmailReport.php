<?php

namespace App\Console\Commands;

use DB;
use PDF;
use Mail;
use Excel;
use App\Package;
use App\Submission;
use App\UserSubmission;
use App\Http\Traits\Airtable;
use \DomDocument;

use Illuminate\Console\Command;

class SendEmailReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Report To Users';

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
        dd($results['data']->toArray());
        $pdf =  Excel::create('Laravel Excel', function ($excel) use (&$results) {
            $excel->sheet('Excel sheet', function ($sheet) use (&$results) {
                $sheet->fromArray($results);
            });
        })->export('xls');

        Mail::send("Email.ThankYouEmailToUser",
        // [
        //
        // ],
        function ($message) use (&$pdf) {
            $message
        ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
        ->to("dnorgarb@gmail.com", "No email record in DB for this referral")
        ->attachData($pdf)
        ->subject("Report");
        });

        return $results;
    }
}
