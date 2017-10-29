<?php

namespace App\Console\Commands;

use DB;
use PDF;
use Mail;
use Excel;
use \Analytics;
use App\Package;
use App\UserLog;
use Carbon\Carbon;
use App\Submission;
use App\UserResult;
use App\UserSubmission;
use App\VendorRefferal;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
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
        $testMails = ["devinn@ebit.co.za", "jonathan@smallbizcrm.com", "devin@smallbizcrm.com"];

        $popularPackages = DB::table('user_results')->select('package_id', 'package_name', DB::raw('COUNT(package_id) AS occurrences'))
         ->groupBy('package_id')
         ->orderBy('occurrences', 'DESC')
         ->limit(10)
         ->get();

        $packages = [];
        foreach ($popularPackages as $key => $id) {
            $package = Package::where('id', $id->package_id)->get();
            $packageMerge = $package->put("occurrences", $id->occurrences);
            $packages[] = $packageMerge->all();
        }

        $vendorRefferals = VendorRefferal::all();

        $pageLoads = UserLog::whereNotNull('page')->get();
        $pageLoadsToday = UserLog::whereBetween('created_at', array(Carbon::now()->subDays(1), Carbon::now()))->get();

        $pages = [];
        foreach ($pageLoads as $key => $pageLoad) {
            $pages[] = $pageLoad->page;
        }
        $popularPages =  array_count_values($pages);
        $popularPages = array_flip($popularPages);
        $startDate = Carbon::now()->subYear();
        $endDate = Carbon::now();
        $timePeriod = Period::create($startDate, $endDate);
        $popularPages = Analytics::fetchMostVisitedPages(Period::days(7));
        $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        $topReferrers = Analytics::fetchTopReferrers($timePeriod, 50);
        $topBrowsers = Analytics::fetchTopBrowsers($timePeriod, 50);
        $maxTime = $pageLoads->sortByDesc('time_spent');
        $maxTime = $maxTime->values();
        $medianTime = $maxTime->avg('time_spent');
        $totalSubmissionsOldNew = Submission::all();
        $totalSubmissions = UserResult::all();
        $submissionsLastMonth = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(30), Carbon::now()))->get();
        $submissionsLastWeek = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(8), Carbon::now()))->get();
        $emailsSentTotal = DB::table('email_log')->orderBy('date', 'desc')->paginate(10);
        $emailsSentTotalCount = DB::table('email_log')->orderBy('date', 'desc');
        $emailsSentTotalCount = $emailsSentTotalCount->count();
        $emailsSentProduction = DB::table('email_log')->whereNotIn('to', $testMails)->orderBy('date', 'desc')->paginate(10);
        $submissionsToday = Submission::whereBetween('created', array(Carbon::now()->subDays(1), Carbon::now()))->get();
        $submissionsYesterday = Submission::whereBetween('created', array(Carbon::now()->subDays(2), Carbon::now()))->get();
        $submissionsTodayNEW = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(1), Carbon::now()))->get();
        $submissionsYesterdayNEW = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(2), Carbon::now()))->get();
        $submissionsLastMonth = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(30), Carbon::now()))->get();
        $submissionsLastWeek = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(8), Carbon::now()))->get();


        $time = date('H:i:s');
        $name = 'SBCRM'.$time;
        $pdf =  Excel::create($name, function ($excel) use (&$submissionsLastMonth) {
            $excel->setTitle('Submissions Past Month Report');
            $excel->setCreator('Devin')
            ->setCompany('SmallBizCRM');
            // Call them separately
            $excel->setDescription('Report of submissions over thje last 30 days');
            $excel->sheet('Excel sheet', function ($sheet) use (&$submissionsLastMonth) {
                $sheet->fromArray($submissionsLastMonth->toArray());
            });
        })->store('xls');



        Mail::send("emails-sent", [
        "maxTime" => $maxTime,
        "medianTime" => $medianTime,
        "emailsSentTotalCount" => $emailsSentTotalCount,
        "pageLoads" => $pageLoads,
        "pageLoadsToday" => $pageLoadsToday,
        "popularPages" => $popularPages,
        "vendorRefferals" => $vendorRefferals,
        "emailsSentTotal" => $emailsSentTotal,
        "packages" => $packages,
        "submissionsLastMonth" => $submissionsLastMonth,
        "submissionsLastWeek" => $submissionsLastWeek,
        "analyticsData" => $analyticsData,
        "topReferrers" => $topReferrers,
        "topBrowsers" => $topBrowsers,
        "totalSubmissions" => $totalSubmissions,
        "totalSubmissionsOldNew" => $totalSubmissionsOldNew,
        "submissionsToday" => $submissionsToday,
        "submissionsTodayNEW" => $submissionsYesterday,
        "submissionsYesterdayNEW" => $submissionsTodayNEW,
        "submissionsYesterday" => $submissionsYesterdayNEW,
      ], function ($message) use ($name) {
          if (env('APP_ENV') != 'production') {
              $message
              ->from("devin@smallbizcrm.com", "SmallBizCRM.com")
              ->to("dnorgarb@gmail.com", "Report")
              ->attach(storage_path('exports/').$name.'.xls')
              ->subject("Report");
          }
          if (env('APP_ENV') == 'production') {
              $message
              ->from("devin@smallbizcrm.com", "SmallBizCRM.com")
              ->to("devin@smallbizcrm.com", "Report")
              ->to("perry@smallbizcrm.com", "Report")
              ->to("theresa@smallbizcrm.com", "Report")
              ->attach(storage_path('exports/').$name.'.xls')
              ->subject("Report");
          }
      });

        if (env('APP_ENV') != 'production') {
            $backup = Mail::getSwiftMailer();
            // Setup your mailgun mailer
            $transport = \Swift_SmtpTransport::newInstance('smtp.mailgun.org', 587);
            $transport->setUsername('postmaster@staging.foodtrees.org');
            $transport->setPassword('2da96d28396f6c5bec011792daf74adb');
            $mailgun = new \Swift_Mailer($transport);
            // Set the mailer as mailgun
            Mail::setSwiftMailer($mailgun);
        }



        if (env('APP_ENV') != 'production') {
            Mail::setSwiftMailer($backup);
        }
    }

    public function getRefferalsSent()
    {
        $vendorRefferals = VendorRefferal::all();

        $popularPackageRefferals = DB::table('vendor_refferals')->select('package_id', 'package_name', DB::raw('COUNT(package_id) AS occurrences'))
           ->groupBy('package_id')
           ->orderBy('occurrences', 'DESC')
           ->get();

        $vendorRefferalsLastDay = VendorRefferal::whereBetween('created_at', array(Carbon::now()->subDays(1), Carbon::now()))->get();

        $userSubmissions = [];
        foreach ($vendorRefferals as $key => $vendor) {
            $userSubmissions[] = UserResult::where('user_id', $vendor->user_id)->get();
        }

        return view('referrals-sent', compact("vendorRefferals", "userSubmissions", "popularPackageRefferals", "vendorRefferalsLastDay"));
    }
}
