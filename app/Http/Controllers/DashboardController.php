<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use App\Package;
use App\VendorRefferal;
use Carbon\Carbon;
use App\Submission;
use App\UserResult;
use App\UserSubmission;
use App\Http\Traits\Airtable;
use Illuminate\Http\Request;

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
        $testMails = ["devinn@ebit.co.za"];

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

        $submissionsLastMonth = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(30), Carbon::now()))->get();
        $submissionsLastWeek = UserResult::whereBetween('created_at', array(Carbon::now()->subDays(6), Carbon::now()))->get();

        $emailsSentTotal = DB::table('email_log')->orderBy('date', 'desc')->paginate(50);
        $emailsSentTotalCount = DB::table('email_log')->orderBy('date', 'desc');

        $emailsSentTotalCount = $emailsSentTotalCount->count();
        $emailsSentProduction = DB::table('email_log')->whereNotIn('to', $testMails)->orderBy('date', 'desc')->paginate(50);

        return view('emails-sent', compact("emailsSent", "emailsSentTotalCount", "vendorRefferals", "emailsSentTotal", "packages", "submissionsLastMonth", "submissionsLastWeek"));
    }
    public function getRefferalsSent()
    {
        $vendorRefferals = VendorRefferal::all();

        $popularPackageRefferals = DB::table('vendor_refferals')->select('package_id', 'package_name', DB::raw('COUNT(package_id) AS occurrences'))
           ->groupBy('package_id')
           ->orderBy('occurrences', 'DESC')
           ->get();
        // dd($popularPackageRefferals);
        $userSubmissions = [];
        foreach ($vendorRefferals as $key => $vendor) {
            $userSubmissions[] = UserResult::where('user_id', $vendor->user_id)->get();
        }

        return view('referrals-sent', compact("vendorRefferals", "userSubmissions", "popularPackageRefferals"));
    }
}
