<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use \Analytics;
use Charts;
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

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
public $testMails = [
      "devinn@ebit.co.za",
      "devin@ebit.co.za",
      "jonathan@smallbizcrm.com",
      "devin@smallbizcrm.com",
      "theresa@smallbizcrm.com",
      "dnorgarb@gmail.com",
      "norgarb@gmail.com",
      "devin@norgarb.com",
      "perry@norgarb.com",
      "perry@smallbizcrm.com",
      "jonathanrautenbach@gmail.com",
    ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        $submissionsToday = Submission::whereBetween('created', array(Carbon::now()->subDays(1), Carbon::now()))->groupBy('id')->get();
        $submissionsYesterday = Submission::whereBetween('created', array(Carbon::now()->subDays(2), Carbon::now()))->groupBy('id')->get();

        $submissionsLastMonth = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(30), Carbon::now()))->get();
        $submissionsLastWeek = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(8), Carbon::now()))->get();

        $submissionsTodayNEW = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(1), Carbon::now()))->get();
        $submissionsYesterdayNEW = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(2), Carbon::now()))->get();

        $emailsSentTotal = DB::table('email_log')->orderBy('date', 'desc')->paginate(10);
        $emailsSentTotalCount = DB::table('email_log')->orderBy('date', 'desc');

        $emailsSentTotalCount = $emailsSentTotalCount->count();
        $emailsSentProduction = DB::table('email_log')->whereNotIn('to', $this->testMails)->orderBy('date', 'desc')->paginate(10);

        $weeklySubmissionsGraph = $this->weeklySubmissionsGraph();
        $submissionUseLineGraph = $this->submissionUseLineGraph();
        $submissionHistoryGraph = $this->submissionHistoryGraph();

        return view('emails-sent',
        compact(
          "submissionsToday",
          "submissionsTodayNEW",
          "submissionsYesterdayNEW",
          "submissionsYesterday",
          "emailsSent",
          "maxTime",
          "medianTime",
          "emailsSentTotalCount",
          "pageLoads",
          "pageLoadsToday",
          "popularPages",
          "vendorRefferals",
          "emailsSentTotal",
          "packages",
          "submissionsLastMonth",
          "submissionsLastWeek",
          "analyticsData",
          "topReferrers",
          "topBrowsers",
          "totalSubmissions",
          "totalSubmissionsOldNew",
          "weeklySubmissionsGraph",
          "submissionUseLineGraph",
          "submissionHistoryGraph"
        ));
    }

    public function weeklySubmissionsGraph($value='')
    {
      $test = Submission::first();
      // dd($test->created_at);
      $chart = Charts::multiDatabase('bar', 'highcharts')
      // Setup the chart settings
      ->elementLabel("Total")
      ->dataset('Testing ', UserSubmission::whereIn('email', $this->testMails)->get())
      ->dataset('Actual Users', UserSubmission::whereNotIn('email', $this->testMails)->get())
      ->dataset('Total', UserSubmission::all())

      ->title("Test VS Actual Submissions")
      // A dimension of 0 means it will take 100% of the space
      ->dimensions(0, 400) // Width x Height
      ->monthFormat('F Y')
      ->lastByMonth("6", true);

      // submissionUseGraph

      return $chart;
    }

    public function submissionUseLineGraph($value='')
    {
      $chart =  Charts::create('line', 'highcharts')
      ->title('My nice chart')
      ->labels(['First', 'Second', 'Third'])
      ->values([5,10,20])
      ->responsive(true)
      ->dimensions(0,500);

      return $chart;
    }

    public function submissionHistoryGraph($value='')
    {
    $chart =   Charts::multiDatabase('line', 'material')
    ->elementLabel("Total")
    ->elementLabel("Total")
    ->dimensions(1000, 1000)
    ->responsive(true)
    ->title("Submission History Graph")
    ->dataset('Total Platform 2.0 Submissions', UserSubmission::all())
    ->dataset('Total Original Submissions', Submission::all())
    ->dataset('User Results', UserResult::all())
    ->dataset('Actual Users', UserSubmission::whereNotIn('email', $this->testMails)->get())
    ->dataset('Testing ', UserSubmission::whereIn('email', $this->testMails)->get())
    ->groupByMonth('2017', true);

      return $chart;
    }


    public function getRefferalsSent()
    {
        $vendorRefferals = VendorRefferal::all();

        $popularPackageRefferals = DB::table('vendor_refferals')->select('package_id', 'package_name', DB::raw('COUNT(package_id) AS occurrences'))
           ->groupBy('package_id')
           ->orderBy('occurrences', 'DESC')
           ->get();

        $vendorRefferalsLastDay = VendorRefferal::whereBetween('created_at', array(Carbon::now()->subDays(1), Carbon::now()))->get();

        // dd($vendorRefferalsLastDay);
        $userSubmissions = [];
        foreach ($vendorRefferals as $key => $vendor) {
            $userSubmissions[] = UserResult::where('user_id', $vendor->user_id)->get();
        }

        return view('referrals-sent', compact("vendorRefferals", "userSubmissions", "popularPackageRefferals", "vendorRefferalsLastDay"));
    }
}
