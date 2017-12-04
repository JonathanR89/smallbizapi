<?php

namespace App\Http\Controllers;

use DB;
use \PDF;
use Mail;
use Excel;
use App\Vendor;
use App\Package;
use \DomDocument;
use App\UserResult;
use App\Submission;
use App\UserSubmission;
use Illuminate\Http\Request;
use App\Http\Traits\Airtable;
use App\Events\VendorRefferalSent;
use App\Jobs\SendFollowUpCRMFinderEmail;

class EmailAPIController extends Controller
{
    use Airtable;


    public function readReview(Request $request)
    {
        $results_key =  $request->input("results_key");
        $submission =  $request->input("submissionID");
        $vendorID = $request->input('packageID');
        $vendor = Package::where('id', $vendorID)->first();

        if (isset($vendor->read_review_url)) {
          return redirect($vendor->read_review_url);
        }
        return redirect('https://smallbizcrm.com/top-crm-software');
    }

    public function listener(Request $request)
    {
        $results_key =  $request->input("results_key");
        $submission =  $request->input("submissionID");
        $vendor = $request->input('vendor');
        $vendorID = $request->input('packageID');

        $submissionData = UserSubmission::where("submission_id", $submission)->first();

        $results = $request->input("results");
        $industry = isset($submissionData->industry) ? $submissionData->industry : "No industry";
        $comments = isset($submissionData->comments) ? $submissionData->comments : "No comments";
        $price = isset($submissionData->price) ? $submissionData->price : "No price" ;
        $email = isset($submissionData->email) ? $submissionData->email : "No email";
        $name = isset($submissionData->name) ? $submissionData->name : "No name";

        $data = [
        "email" => $email,
        "name" => $name,
        "price"  =>  $price,
        "industry"  =>  $industry,
        "comments"  =>  $comments,
        "fname"  =>  $submissionData->fname,
        "total_users" => $submissionData->total_users,
        "infusionsoft_user_id" => $submissionData->infusionsoft_user_id,
      ];


        if (isset($submission)) {
            $scores = DB::table('submissions_metrics')
            ->join('metrics', 'submissions_metrics.metric_id', '=', 'metrics.id')
            ->where('submissions_metrics.submission_id', '=', $submission)
            ->orderBy('metrics.id')
            ->get();
        }

        $vendor = Package::find($vendorID);


        if (isset($scores) && isset($email)) {
            event(new VendorRefferalSent($submissionData, $vendor));
            $this->sendEmailToVendor($email, $vendor, $scores, $data);
        }


        if (isset($email)) {
            $this->sendThankYouMail($email, $name, $vendor);
        }
        return redirect($vendor->visit_website_url);
    }

    public function getEmailsSent()
    {
        $emailsSent = DB::table('email_log')->get();
        return view('emails-sent', compact("emailsSent"));
    }

    // NOTE: Sends mail to vendor
    public function sendEmailToVendor($email, $vendor, $scores, $data)
    {
        Mail::send("Email.EmailToVendorAPI",
      [
        "scores" => $scores,
        "data" => $data,
      ], function ($message) use ($email, $vendor, $scores, $data) {
          $date = date('H:i:s');
          $pdf =  \PDF::loadView("Email.EmailToVendorAPI", ["scores" => $scores, "data" => $data])->setPaper('a4')->setWarnings(false);

          if (isset($vendor->vendor_email)) {
              if (env('APP_ENV') != 'production' || $email == "dnorgarb@gmail.com") {
                  $emails = explode(',', $vendor->test_email);
              } else {
                  $emails = explode(',', $vendor->vendor_email);
              }
              $message
              ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
              ->to($emails, "$vendor->name")
              ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
              ->to("theresa@smallbizcrm.com", "SmallBizCRM.com")
              ->to("perry@smallbizcrm.com", "SmallBizCRM.com")
              ->subject("SmallBizCRM CRM Finder referral " . "$vendor->name")
              ->attachData($pdf->output(), "SmallBizCRM CRM Finder referral " . "$vendor->name".".pdf");
          } else {
              $message
              ->from("perry@smallbizcrm.com", "No email record in DB for this referral")
              ->to("devin@smallbizcrm.com", "No email record in DB for this referral")
              ->to("jonathan@smallbizcrm.com", "No email record in DB for this referral")
              ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
              ->to("theresa@smallbizcrm.com", "No email record in DB for this referral")
              ->subject("No vendor email record in DB for " . "$vendor->name");
          }
      });
    }

    public function sendThankYouMail($email, $name, $vendor)
    {
        Mail::send("Email.ThankYouEmailToUser",
       [
          "name" => $name,
          "crm" => $vendor->name
       ],
        function ($message) use ($email, $name, $vendor) {
            $message
        ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
        ->to($email, $name)
        ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
        ->to("theresa@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
        ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
        ->subject("Thank You " . $name ."," . " " . $vendor->name . " ". "Will be in contact with you shortly ");
        });
    }

    // NOTE Goes To the USer
    public function sendSharedResults(Request $request)
    {
        $airtable = Airtable::getData();
        $vendors = Package::all();

        $submission = $request->input('submissionID');
        $user_id = $request->input('userID');
        $friendsEmail = $request->input('friendsEmail');

        $submissionData = UserSubmission::where(["submission_id" => $submission, "id" => $user_id])->first();
        $results = $request->input("results");

        $industry = isset($submissionData->industry) ? $submissionData->industry : null;
        $comments = isset($submissionData->comments) ? $submissionData->comments : null;
        $price = isset($submissionData->price) ? $submissionData->price : null;
        $email = isset($submissionData->email) ? $submissionData->email : null;
        $name =isset($submissionData->name) ? $submissionData->name : null;
        $totalUsers = isset($submissionData->total_users) ? $submissionData->total_users : null;

        $data = [
          "email" => $email,
          "name" => $name,
          "price"  =>  $price,
          "industry"  =>  $industry,
          "comments"  =>  $comments,
          "fname"  =>  isset($submissionData->fname) ? $submissionData->fname : null,
          "total_users" => $totalUsers,
          "infusionsoft_user_id" => isset($submissionData->infusionsoft_user_id) ? $submissionData->infusionsoft_user_id : null,
          "submission" => $submissionData,
          "submission_id" => $submission,
          "user_id" => $user_id,
        ];

        $submission_ip = Submission::find($submission);

        $resultsKey = md5($submission . $submission_ip->ip . 'qqfoo');

        $resultsData = [];
        foreach ($results as $key => $result) {
            if (isset($result['data'])) {
                $resultsData[] = $result['data'];
            }
        }
        $results =  collect($resultsData)->flatten(1)->toArray();
        if (collect($resultsData)->flatten(1)->isEmpty()) {
            return 'No Results To send';
        }

        $maxScores = UserResult::where([
          "submission_id" => $submission,
          "user_id" => $user_id,
        ])->pluck('score');

        Mail::send("Email.EmailResultsToUserAPI",
        [
            "submission" => $submission,
            "results" => $results,
            "vendors" => $vendors,
            "total_users" => $totalUsers,
            "test"  =>  $email,
            "results_key" =>  $resultsKey,
            "max" =>  $maxScores->max(),
            "data" => $data,
            "submission_id" => $submission,
            "user_id" => $user_id,
        ],

        function ($message) use (&$email, &$name, $friendsEmail) {
            $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($email, $name)
          ->to("theresa@smallbizcrm.com", $name)
          ->to("perry@smallbizcrm.com", $name)
          ->to($friendsEmail, $friendsEmail)
          ->subject("$name shared their results from SmallBizCRM.com CRM Finder");
        });

        $userData = [
          "email" => $email,
          "name" => $name,
        ];

        return [ "sent" => true];
    }

    // NOTE Goes To the USer
    public function sendUsersResults(Request $request)
    {
        $airtable = Airtable::getData();
        $vendors = Package::all();

        $submission = $request->input('submissionID');
        $user_id = $request->input('userID');

        $submissionData = UserSubmission::where(["submission_id" => $submission, "id" => $user_id])->first();
        $results = $request->input("results");

        $industry = isset($submissionData->industry) ? $submissionData->industry : null;
        $comments = isset($submissionData->comments) ? $submissionData->comments : null;
        $price = isset($submissionData->price) ? $submissionData->price : null;
        $email = isset($submissionData->email) ? $submissionData->email : null;
        $name =isset($submissionData->name) ? $submissionData->name : null;
        $totalUsers = isset($submissionData->total_users) ? $submissionData->total_users : null;

        $data = [
          "email" => $email,
          "name" => $name,
          "price"  =>  $price,
          "industry"  =>  $industry,
          "comments"  =>  $comments,
          "fname"  =>  isset($submissionData->fname) ? $submissionData->fname : null,
          "total_users" => $totalUsers,
          "infusionsoft_user_id" => isset($submissionData->infusionsoft_user_id) ? $submissionData->infusionsoft_user_id : null,
          "submission" => $submissionData,
          "submission_id" => $submission,
          "user_id" => $user_id,
        ];

        $submission_ip = Submission::find($submission);

        $resultsKey = md5($submission . $submission_ip->ip . 'qqfoo');

        $resultsData = [];
        foreach ($results as $key => $result) {
            if (isset($result['data'])) {
                $resultsData[] =$result['data'];
            }
        }
        $results =  collect($resultsData)->flatten(1)->toArray();
        
        if (collect($resultsData)->flatten(1)->isEmpty()) {
            return 'No Results To send';
        }

        $maxScores = UserResult::where([
          "submission_id" => $submission,
          "user_id" => $user_id,
        ])->pluck('score');

        Mail::send("Email.EmailResultsToUserAPI",
        [
            "submission" => $submission,
            "results" => $results,
            "vendors" => $vendors,
            "total_users" => $totalUsers,
            "test"  =>  $email,
            "results_key" =>  $resultsKey,
            "max" =>  $maxScores->max(),
            "data" => $data,
            "submission_id" => $submission,
            "user_id" => $user_id,
        ],

        function ($message) use (&$email, &$name, $submission) {
            $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($email ? $email : 'devin@smallbizcrm.com', $name)
          ->to("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
          ->to("theresa@smallbizcrm.com", "SmallBizCRM.com")
          ->subject("Results from SmallBizCRM.com");
        });

        $userData = [
          "email" => $email,
          "name" => $name,
          "submission_id" => $submission,
        ];

        // $job = (new SendFollowUpCRMFinderEmail($userData))->delay(\Carbon\Carbon::now('Africa/Cairo')->addMinutes(30));
        // NOTE:// UNCOMMENT WHEN THERESA IS BACK
        if ($email == "dnorgarb@gmail.com") {
            $job = (new SendFollowUpCRMFinderEmail($userData))->delay(\Carbon\Carbon::now('Africa/Cairo')->addMinutes(2));
        }
        dispatch($job);

        $this->sendUserScoreSheet($results, $name, $industry, $comments, $submission, $price, $email, $user_id);
        return [ "sent" => true];
    }


    // NOTE QQ2 submission goes only to dad and theresa + jono
    public function sendUserScoreSheet($results, $name, $industry = null, $comments = null, $submission, $price = null, $email = null, $user_id)
    {
        $db = DB::connection()->getPdo();

        $sql = 'SELECT metrics.name, submissions_metrics.score FROM submissions_metrics INNER JOIN metrics ON submissions_metrics.metric_id = metrics.id WHERE submissions_metrics.submission_id = ? ORDER BY metrics.id';
        $stmt = $db->prepare($sql);
        $stmt->execute([$submission]);
        $answers = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $maxScores = UserResult::where([
          "submission_id" => $submission,
          "user_id" => $user_id,
        ])->pluck('score');

        Mail::send("Email.EmailUsersScoresheetAPI",
       [
          "name" => $name,
          "results" => collect($results),
          "industry" => $industry,
          "comments" => $comments,
          "answers" => $answers,
          "price" => $price,
          "max" =>  $maxScores->max(),
          "submission_id" => $submission,
          "user_id" => $user_id,
          "email" => $email,
       ],
        function ($message) use (&$name) {
            $message
        ->from("perry@smallbizcrm.com", "QQ2 Submission")
        ->to("perry@smallbizcrm.com", "Perry")
        ->to("devin@smallbizcrm.com", "Devin")
        ->to("jonathan@smallbizcrm.com", "Jonathan")
        ->to("theresa@smallbizcrm.com", "Theresa")
        ->subject("QQ2 Submission");
        });
    }
}
