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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $submissionsToday = Submission::whereBetween('created', array(Carbon::now()->subDays(1), Carbon::now()))->groupBy('id')->get();
        $submissionsYesterday = Submission::whereBetween('created', array(Carbon::now()->subDays(2), Carbon::now()))->groupBy('id')->get();

        $submissionsLastMonth = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(30), Carbon::now()))->get();
        $submissionsLastWeek = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(8), Carbon::now()))->get();

        $submissionsTodayNEW = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(1), Carbon::now()))->get();
        $submissionsYesterdayNEW = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(2), Carbon::now()))->get();

        $emailsSentTotal = DB::table('email_log')->orderBy('date', 'desc')->paginate(10);
        $emailsSentTotalCount = DB::table('email_log')->orderBy('date', 'desc');

        $emailsSentTotalCount = $emailsSentTotalCount->count();
        $emailsSentProduction = DB::table('email_log')->whereNotIn('to', $testMails)->orderBy('date', 'desc')->paginate(10);

        $submissionUseGraph = $this->submissionUseGraph();
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
          "submissionUseGraph",
          "submissionUseLineGraph",
          "submissionHistoryGraph"
        ));
    }

    public function submissionUseGraph($value='')
    {
      $test = Submission::first();
      // dd($test->created_at);
      $chart = Charts::multi('bar', 'material')
      // Setup the chart settings
      ->title("My Cool Chart")
      // A dimension of 0 means it will take 100% of the space
      ->dimensions(0, 400) // Width x Height
      // This defines a preset of colors already done:)
      ->template("material")
      // You could always set them manually
      // ->colors(['#2196F3', '#F44336', '#FFC107'])
      // Setup the diferent datasets (this is a multi chart)
      ->dataset('Element 1', [5,20,100])
      ->dataset('Element 2', [15,30,80])
      ->dataset('Element 3', [25,10,40])
      // Setup what the values mean
      ->labels(['One', 'Two', 'Three']);

      // submissionUseGraph

      return $chart;
    }

    public function submissionUseLineGraph($value='')
    {
      $chart =  Charts::create('line', 'highcharts')
      ->title('My nice chart')
      ->labels(['First', 'Second', 'Third'])
      ->values([5,10,20])
      ->dimensions(0,500);
      # code...
      return $chart;
    }

    public function submissionHistoryGraph($value='')
    {
      // $chart = Charts::database(UserSubmission::all(), 'line', 'material')
      //     ->elementLabel("Total")
      //     ->dimensions(1000, 500)
      //     ->responsive(true)
      //     ->groupByMonth();

    $chart =   Charts::multiDatabase('line', 'highcharts')
    ->elementLabel("Total")
    ->elementLabel("Total")
    ->dimensions(1000, 500)
    ->responsive(true)
    ->dataset('Platform 2.0 Submissions', UserSubmission::all())
    // ->dateColumn('created_at')
    ->dataset('Original Submissions', Submission::all())
    ->dataset('User Results', UserResult::all())
    // ->dateColumn('created')
    ->groupByMonth('2017', true);
    // dd($chart);
      # code...
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
