<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use \DomDocument;
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
        $results_key =  $request->input("results_key");
        $submission =  $request->input("submissionID");
        $vendor = $request->input('vendor');

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

        $AirtableData = Airtable::getEntryByPackageName($vendor);



        if (isset($scores) && isset($email)) {
            event(new VendorRefferalSent($submissionData, collect($AirtableData)));
            $this->sendEmailToVendor($email, $AirtableData, $scores, $data);
        }


        if (isset($email)) {
            $this->sendThankYouMail($email, $name, $AirtableData);
        }
        return ["sent" => true];
    }

    public function getEmailsSent()
    {
        $emailsSent = DB::table('email_log')->get();
        return view('emails-sent', compact("emailsSent"));
    }

    // NOTE: Sends mail to vendor
    public function sendEmailToVendor($email, $AirtableData, $scores, $data)
    {
        if ($email == "dnorgarb@gmail.com" || env('APP_ENV') != 'production' && isset($AirtableData[0]->{'vendor_email_testing'})) {
            if (!isset($AirtableData[0]->{'vendor_email_testing'})) {
                $noVendorEmail = true;
            } else {
                $noVendorEmail = false;
            }
        } else {
            if (!isset($AirtableData[0]->{'Vendor Email'})) {
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
      ], function ($message) use ($email, $AirtableData, $scores, $data, $noVendorEmail) {
          $date = date('H:i:s');
          $pdf =  PDF::loadView("Email.EmailToVendorAPI", ["scores" => $scores, "data" => $data, "noVendorEmail" => $noVendorEmail])->setPaper('a4')->setWarnings(false);


          if (isset($AirtableData[0]->{'Vendor Email'})) {
              if ($email == "dnorgarb@gmail.com" || env('APP_ENV') != 'production' && isset($AirtableData[0]->{'vendor_email_testing'})) {
                  $emails = explode(',', $AirtableData[0]->{'vendor_email_testing'});
              } else {
                  $emails = explode(',', $AirtableData[0]->{'Vendor Email'});
              }
              var_dump($emails);
              $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($emails, "{$AirtableData[0]->CRM}")
          ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
          ->subject("SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}")
          ->attachData($pdf->output(), "SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}".".pdf");
          } else {
              $message
          ->from("perry@smallbizcrm.com", "No email record in DB for this referral")
          ->to("devin@smallbizcrm.com", "No email record in DB for this referral")
              ->to("jonathan@smallbizcrm.com", "No email record in DB for this referral")
              ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
              ->to("theresa@smallbizcrm.com", "No email record in DB for this referral")
              ->subject("No vendor email record in DB for " . "{$AirtableData[0]->CRM}");
          }
      });
    }

    public function sendThankYouMail($email, $name, $AirtableData)
    {
        Mail::send("Email.ThankYouEmailToUser",
       [
          "name" => $name,
          "crm" => $AirtableData[0]->CRM
       ],
        function ($message) use ($email, $name, $AirtableData) {
            $message
        ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
        ->to($email, $name)
        ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
        // ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
        ->subject("Thank You " . $name ."," . " " . $AirtableData[0]->CRM . " ". "Will be in contact with you shortly ");
        });
    }

    // NOTE Goes To the USer
    public function sendUsersResults(Request $request)
    {
        $airtable = Airtable::getData();

        $submission = $request->input('submissionID');
        $user_id = $request->input('userID');

        $submissionData = UserSubmission::where(["submission_id" => $submission, "id" => $user_id])->first();
        $results = $request->input("results");
        $industry = $submissionData->industry;
        $comments = $submissionData->comments;
        $price = $submissionData->price;

        $data = [
          "email" => $submissionData->email,
          "name" => $submissionData->name,
          "price"  =>  $submissionData->price,
          "industry"  =>  $submissionData->industry ,
          "comments"  =>  $submissionData->comments,
          "fname"  =>  $submissionData->fname,
          "total_users" => $submissionData->total_users,
          "infusionsoft_user_id" => $submissionData->infusionsoft_user_id,
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
        $email = $submissionData->email;
        $name = $submissionData->name;
        $max = isset($max) ? $max : 0;
        Mail::send("Email.EmailResultsToUserAPI",
        [
            "submission" => $submission,
            "results" => $results,
            "airtable" => $airtable,
            "total_users" => $submissionData->total_users,
            "test"  =>  $submissionData->email,
            "results_key" =>  $resultsKey,
            "max" =>  $max,
            "data" => $data,

        ],
        function ($message) use (&$email, &$name) {
            $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($email, $name)
          ->to("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
          ->subject("Results from SmallBizCRM.com");
        });

        $userData = [
          "email" => $email,
          "name" => $name,
        ];

        dispatch(new SendFollowUpCRMFinderEmail($userData));
        $job = (new SendFollowUpCRMFinderEmail($userData))->delay(\Carbon\Carbon::now('Africa/Cairo')->addMinutes(2));
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
        // dd("here");
        // dd($results);
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
