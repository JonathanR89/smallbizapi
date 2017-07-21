<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use Illuminate\Http\Request;
use App\Http\Traits\Airtable;
use App\UserSubmission;
use App\Submission;
use \DomDocument;

class EmailAPIController extends Controller
{
    use Airtable;

    public function listener(Request $request)
    {
        $vendor = $request->input("vendor");
        $email =  $request->input("email");
        $data =  $request->input("data");
        $data = json_decode($data);
        $name =  $request->input("user_name");
        $results_key =  $request->input("results_key");
        $submission =  $request->input("sub_id");
        $uri  = $request->input("uri");
        $host  = $request->input("host");
        $total_users =   $request->input("total_users");
        $results =  urldecode($request->input("results"));
        $data = collect($data);
        $data->put('total_users', $total_users);
        $results = json_decode($results);

        if (isset($submission)) {
            $scores = DB::table('submissions_metrics')
                    ->join('metrics', 'submissions_metrics.metric_id', '=', 'metrics.id')
                    ->where('submissions_metrics.submission_id', '=', $submission)
                    ->orderBy('metrics.id')
                    ->get();
        }

        $AirtableData = Airtable::getEntryByPackageName($vendor);

        if (isset($scores) && isset($email)) {
            $this->sendEmailToVendor($email, $AirtableData, $scores, $data);
        }

        if (isset($email)) {
            $this->sendThankYouMail($email, $name, $AirtableData);
        }

        if (isset($AirtableData[0]->{'Column 10'})) {
            return redirect("{$AirtableData[0]->{'Column 10'}}");
        } elseif (isset($AirtableData[0]->{'Visit Website Button'})) {
            return redirect("{$AirtableData[0]->{'Visit Website Button'}}");
        } else {
            return redirect()->back();
        }


        return redirect()->back();
    }

    public function getEmailsSent()
    {
        $emailsSent = DB::table('email_log')->get();
        return view('emails-sent', compact("emailsSent"));
    }

    // NOTE: Sends mail to vendor
    public function sendEmailToVendor($email, $AirtableData, $scores, $data)
    {
        if ($email == "dnorgarb@gmail.com") {
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
        Mail::send("Email.EmailToVendor",
      [
        "scores" => $scores,
        "data" => $data,
        "noVendorEmail" => $noVendorEmail
      ], function ($message) use ($email, $AirtableData, $scores, $data, $noVendorEmail) {
          $date = date('H:i:s');
          $pdf =  PDF::loadView("Email.EmailToVendor", ["scores" => $scores, "data" => $data, "noVendorEmail" => $noVendorEmail])->setPaper('a4')->setWarnings(false);


          if (isset($AirtableData[0]->{'Vendor Email'})) {
              if ($email == "dnorgarb@gmail.com") {
                  $emails = explode(',', $AirtableData[0]->{'vendor_email_testing'});
              } else {
                  $emails = explode(',', $AirtableData[0]->{'Vendor Email'});
              }
              $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($emails, "{$AirtableData[0]->CRM}")
          ->subject("SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}")
          ->attachData($pdf->output(), "SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}".".pdf");
          } else {
              $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to("dnorgarb@gmail.com", "No email record in DB for this referral")
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
        ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
        ->subject("Thank You " . $name ."," . " " . $AirtableData[0]->CRM . " ". "Will be in contact with you shortly ");
        });
    }

    // NOTE Goes To the USer
    public function sendUsersResults(Request $request)
    {
        $airtable = Airtable::getData();
        // dd($request->all());
        $submission = $request->input('submissionID');

        $submissionData = UserSubmission::where("submission_id", $submission)->first();
        $results = $request->input("results");
        $industry = $submissionData->industry;
        $comments = $submissionData->comments;
        $price = $submissionData->price;
        // dd($submissionData);
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

        $submission_ip = Submission::find($submission);

        $resultsKey = md5($submission . $submission_ip->ip . 'qqfoo');

        foreach ($results as $key => $result) {
            if ($result['data']) {
                $resultsData[] =$result['data'];
            }
        }
        $results =  collect($resultsData)->flatten(1)->toArray();

        $email = $submissionData->email;
        $name = $submissionData->name;
        Mail::send("Email.EmailResultsToUserAPI",
        [
            "submission" => $submission,
            "results" => $results,
            "airtable" => $airtable,
            "total_users" => $submissionData->total_users,
            "test"  =>  $submissionData->email,
            "results_key" =>  $resultsKey,
            "max" =>  $max ?? 0,
            "data" => $data,

        ],
        function ($message) use ($email, $name) {
            $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($email, $name)
          ->to($email, $name)
          // ->to("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to("dnorgarb@gmail.com", "SmallBizCRM.com")
          ->to("dnorgarb@gmail.com", "SmallBizCRM.com")
          ->to("dnorgarb@gmail.com", "SmallBizCRM.com")

          ->subject("Results from SmallBizCRM.com");
        });
        $this->sendUserScoreSheet($results, $name, $industry, $comments, $submission, $price, $email);
        return "sent";
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
        function ($message) use ($name) {
            $message
        ->from("perry@smallbizcrm.com", "QQ2 Submission")
        // ->to("perry@smallbizcrm.com", "Perry")
        ->to("dnorgarb@gmail.com", "Devin")
        // ->to("jonathan@smallbizcrm.com", "Jonathan")
        // ->to("theresa@smallbizcrm.com", "Theresa")
        ->subject("QQ2 Submission");
        });
    }
}
