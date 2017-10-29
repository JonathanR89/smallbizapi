<?php

namespace App\Http\Controllers;

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

        $submissionsToday = Submission::whereBetween('created', array(Carbon::now()->subDays(1), Carbon::now()))->get();
        $submissionsYesterday = Submission::whereBetween('created', array(Carbon::now()->subDays(2), Carbon::now()))->get();

        $submissionsLastMonth = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(30), Carbon::now()))->get();
        $submissionsLastWeek = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(8), Carbon::now()))->get();

        $submissionsTodayNEW = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(30), Carbon::now()))->get();
        $submissionsYesterdayNEW = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(8), Carbon::now()))->get();

        $emailsSentTotal = DB::table('email_log')->orderBy('date', 'desc')->paginate(10);
        $emailsSentTotalCount = DB::table('email_log')->orderBy('date', 'desc');

        $emailsSentTotalCount = $emailsSentTotalCount->count();
        $emailsSentProduction = DB::table('email_log')->whereNotIn('to', $testMails)->orderBy('date', 'desc')->paginate(10);

        return view('emails-sent',
        compact(
          "submissionsToday",
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
          "totalSubmissionsOldNew"
        ));
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
