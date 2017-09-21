<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use \DomDocument;
use App\Package;
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


    public function listener(Request $request)
    {
        // dd($request->all());
        $results_key =  $request->input("results_key");
        $submission =  $request->input("submissionID");
        $vendor = $request->input('vendor');
        $vendorID = $request->input('packageID');

        $submissionData = UserSubmission::where("submission_id", $submission)->first();

        $results = $request->input("results");
        $industry = $submissionData->industry;
        $comments = $submissionData->comments;
        $price = $submissionData->price;
        $email = $submissionData->email;
        $name = $submissionData->name;

        $data = [
        "email" => $submissionData->email,
        "name" => $submissionData->name,
        "price"  =>  $submissionData->price,
        "industry"  =>  $submissionData->industry,
        "comments"  =>  $submissionData->comments,
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

        // $AirtableData = Airtable::getEntryByPackageName($vendor);
        // dd($vendorID);
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
        // dd($email, $vendor, $scores, $data);
        if ($email == "dnorgarb@gmail.com" || env('APP_ENV') != 'production' && isset($vendor->test_email)) {
            if (!isset($vendor->test_email)) {
                $noVendorEmail = true;
            } else {
                $noVendorEmail = false;
            }
        } else {
            if (!isset($vendor->vendor_email)) {
                $noVendorEmail = true;
            } else {
                $noVendorEmail = false;
            }
        }

        Mail::send("Email.EmailToVendorAPI",
      [
        "scores" => $scores,
        "data" => $data,
        "noVendorEmail" => $noVendorEmail
      ], function ($message) use ($email, $vendor, $scores, $data, $noVendorEmail) {
          $date = date('H:i:s');
          $pdf =  PDF::loadView("Email.EmailToVendorAPI", ["scores" => $scores, "data" => $data, "noVendorEmail" => $noVendorEmail])->setPaper('a4')->setWarnings(false);


          if (isset($vendor->vendor_email)) {
              if ($email == "dnorgarb@gmail.com" || env('APP_ENV') != 'production' && isset($vendor->test_email)) {
                  $emails = explode(',', $vendor->test_email);
              } else {
                  $emails = explode(',', $vendor->vendor_email);
              }
              // dd($vendor);
              var_dump($emails);
              $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($emails, "$vendor->name")
          ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
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
        ->to($email ? $email : 'devin@smallbizcrm.com', $name)
        ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
        // ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
        ->subject("Thank You " . $name ."," . " " . $vendor->name . " ". "Will be in contact with you shortly ");
        });
    }

    // NOTE Goes To the USer
    public function sendUsersResults(Request $request)
    {
        $airtable = Airtable::getData();
        $vendors = Package::all();

        $submission = $request->input('submissionID');
        $user_id = $request->input('userID');
        // dd($user_id);
        $submissionData = UserSubmission::where(["submission_id" => $submission, "id" => $user_id])->first();
        $results = $request->input("results");
        // $industry = $submissionData->industry;
        // $comments = $submissionData->comments;
        // $price = $submissionData->price;
        // dd($request->all());
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
            // "submission" => $submissionData,
            "submission_id" => $submission,
            "user_id" => $user_id,
        ],

        function ($message) use (&$email, &$name) {
            // dd($email, $name);
            $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($email ? $email : 'devin@smallbizcrm.com', $name)
          // ->to($email, $name)

          ->to("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
          ->subject("Results from SmallBizCRM.com");
        });

        $userData = [
          "email" => $email,
          "name" => $name,
        ];

        $job = (new SendFollowUpCRMFinderEmail($userData))->delay(\Carbon\Carbon::now('Africa/Cairo')->addMinutes(30));
        if ($email == "dnorgarb@gmail.com") {
            $job = (new SendFollowUpCRMFinderEmail($userData))->delay(\Carbon\Carbon::now('Africa/Cairo')->addMinutes(2));
        }
        // $job = (new SendFollowUpCRMFinderEmail($userData));
        dispatch($job);

        $this->sendUserScoreSheet($results, $name, $industry, $comments, $submission, $price, $email);
        return [ "sent" => true];
    }


    // NOTE QQ2 submission goes only to dad and theresa + jono
    public function sendUserScoreSheet($results, $name, $industry = null, $comments = null, $submission, $price = null, $email = null)
    {
        $db = DB::connection()->getPdo();

        $sql = 'SELECT metrics.name, submissions_metrics.score FROM submissions_metrics INNER JOIN metrics ON submissions_metrics.metric_id = metrics.id WHERE submissions_metrics.submission_id = ? ORDER BY metrics.id';
        $stmt = $db->prepare($sql);
        $stmt->execute([$submission]);
        $answers = $stmt->fetchAll(\PDO::FETCH_OBJ);

        Mail::send("Email.EmailUsersScoresheetAPI",
       [
          "name" => $name,
          "results" => $results,
          "industry" => $industry,
          "comments" => $comments,
          "answers" => $answers,
          "price" => $price,
          "email" => $email,
       ],
        function ($message) use (&$name) {
            $message
        ->from("perry@smallbizcrm.com", "QQ2 Submission")
        ->to("perry@smallbizcrm.com", "Perry")
        // ->to("dnorgarb@gmail.com", "Devin")
        ->to("devin@smallbizcrm.com", "Devin")
        ->to("jonathan@smallbizcrm.com", "Jonathan")
        ->to("theresa@smallbizcrm.com", "Theresa")
        ->subject("QQ2 Submission");
        });
    }
}
