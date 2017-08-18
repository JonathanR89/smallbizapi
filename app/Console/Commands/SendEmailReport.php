<?php

namespace App\Console\Commands;

use DB;
use PDF;
use Mail;
use Excel;
use App\Package;
use Carbon\Carbon;
use App\Submission;
use App\UserResult;
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
                    $results[] = $row->toArray();
                  //   $results[] = [
                  //   "data" => $row->toArray(),
                  //   "airtableData" => $record->fields,
                  // ];
                }
            }
        }
        $time = date('H:i:s');
        $name = 'SBCRM'.$time;
        $pdf =  Excel::create($name, function ($excel) use (&$results) {
            $excel->setTitle('Our new awesome title');
            $excel->setCreator('Maatwebsite')
                ->setCompany('Maatwebsite');

          // Call them separately
          $excel->setDescription('A demonstration to change the file properties');
            $excel->sheet('Excel sheet', function ($sheet) use (&$results) {
                $sheet->fromArray($results);
            });
        })->store('xls');
        // dd(storage_path('exports/').'SBCRM'.$time);
        // dd('here');

        $backup = Mail::getSwiftMailer();

        // Setup your gmail mailer
        $transport = \Swift_SmtpTransport::newInstance('smtp.mailgun.org', 587);
        $transport->setUsername('postmaster@staging.foodtrees.org');
        $transport->setPassword('2da96d28396f6c5bec011792daf74adb');

        $mailgun = new \Swift_Mailer($transport);

        // Set the mailer as gmail
        Mail::setSwiftMailer($mailgun);
        // Any other mailer configuration stuff needed...

        $submissionsLastMonth = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(30), Carbon::now()))->get();
        $submissionsLastWeek = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(6), Carbon::now()))->get();
        // dd($submissionsLastWeek);
        $data =[
          'submissionsLastWeek' => $submissionsLastWeek,
          'submissionsLastMonth' => $submissionsLastMonth,
        ];
        Mail::send("Email.EmailReportAPI", ['data' => $data],
        function ($message) use ($name) {
            $message
        ->from("test@smallbizcrm.com", "SmallBizCRM.com")
        ->to("dnorgarb@gmail.com", "No email record in DB for this referral")
        ->attach(storage_path('exports/').$name.'.xls')
        ->subject("Report");
        });
        Mail::setSwiftMailer($backup);

        return $results;
    }
}