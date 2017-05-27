<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use Illuminate\Http\Request;
use App\Http\Traits\Airtable;
use \DomDocument;

class EmailController extends Controller
{
    use Airtable;

    public function listener(Request $request)
    {
      // dd($request->all());
        $vendor = $request->input("vendor");
        $email =  $request->input("email");

        $data =  $request->input("data");
        $data = json_decode($data);

        $name =  $request->input("user_name");
        $results_key =  $request->input("results_key");
        $submission =  $request->input("sub_id");
        $uri  = $request->input("uri");
        $host  = $request->input("host");

        $results =  urldecode($request->input("results"));
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
              $this->sendThankYouMail($email,$name,$AirtableData);
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
      Mail::send("Email.EmailToVendor",
      [
        "scores" => $scores,
        "data" => $data
      ], function ($message) use ($email, $AirtableData, $scores, $data) {

        $date = date('H:i:s');
        $pdf =  PDF::loadView("Email.EmailToVendor",  ["scores" => $scores, "data" => $data])->setPaper('a4' )->setWarnings(true);

        if (isset($AirtableData[0]->{'Vendor Email'})) {
          $emails = explode(',', $AirtableData[0]->{'Vendor Email'});
          $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to($emails, "{$AirtableData[0]->CRM}")
          ->subject("SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}")
          ->attachData($pdf->output(), "SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}".".pdf");
        } else {
          $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to("dnorgarb@gmail.com", "No email record in DB for this referral")
          ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
          ->subject("No vendor email record in DB for " . "{$AirtableData[0]->CRM}");
        }
      });
    }

    public function sendThankYouMail($email,$name,$AirtableData)
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
        ->subject( "Thank You " . $name ."," . " " . $AirtableData[0]->CRM . " ". "Will be in contact with you shortly ");
      });
    }

    // NOTE Goes To the USer
    public function sendUsersResults(Request $request)
    {
      $body = $request->input('body');
      // $body = urldecode($body);
      $email = $request->input('email');
      $results = $request->input('results');
      $name = $request->input('name');


      Mail::send("Email.EmailResultsToUser",
       [
          "name" => $name,
          "body" => $body,
          "email" => $email,
          // "crm" => $AirtableData[0]->CRM,
          "results" => $results,
       ],
        function ($message) use ($email, $name) {
        $message
        ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
        ->to($email, $name)
        ->subject( "Results from SmallBizCRM.com");
      });
    }

    // NOTE QQ2 submission goes only to dad and theresa + jono
    public function sendUserScoreSheet(Request $request)
    {

      $body = $request->input('body');
      $results = $request->input('results');
      $name = $request->input('name');

      $emails = [
        "perry@smallbizcrm.com",
        // "theresa@smallbizcrm.com",
        // "norgarb@gmail.com",
         "dnorgarb@gmail.com",
          // "devinn@ebit.co.za",
          //  "devin@norgarb.com",
          // "perry@smallbizcrm.com",
          "jonathan@smallbizcrm.com",
      ];

      Mail::send("Email.EmailUsersScoresheet",
       [
          "name" => $name,
          "body" => $body,
          "results" => $results,
       ],
        function ($message) use ($emails, $name) {
        $message
        ->from("perry@smallbizcrm.com", "QQ2 Submission")
        ->to("perry@smallbizcrm.com", "Perry")
        ->to("dnorgarb@gmail.com", "Devin")
        ->to("jonathan@smallbizcrm.com", "Jonathan")
        ->to("theresa@smallbizcrm.com", "Theresa")
        ->subject("QQ2 Submission");
      });
    }



}
