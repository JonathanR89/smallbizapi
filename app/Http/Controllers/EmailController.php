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
        $email_score_body = urldecode($request->input("email_score_body"));
        $vendor_email_score_body = urldecode($request->input("vendor_email_score_body"));
        $results =  urldecode($request->input("results"));
        $results = json_decode($results);
        $vendor_email_score_body = filter_var($vendor_email_score_body);
        // dd($vendor_email_score_body);
        if (isset($submission)) {
          $scores = DB::table('submissions_metrics')
                    ->join('metrics', 'submissions_metrics.metric_id', '=', 'metrics.id')
                    ->where('submissions_metrics.submission_id', '=', $submission)
                    ->orderBy('metrics.id')
                    ->get();
        }
        if (isset($results)) {
        $result = [];
        foreach ($results as $vendor_selected) {
          if (in_array($vendor, (array)$vendor_selected)) {
            $result[] = $vendor_selected;
          }
        }
      }

  // dd($data);

        $AirtableData = Airtable::getEntryByPackageName($vendor);

        if (isset($vendor)) {
          if (!isset($scores)) {
            Mail::send("Email.EmailToVendor",
            [
              "email_score_body" => $vendor_email_score_body
            ], function ($message) use ($email, $AirtableData, &$vendor_email_score_body) {
              if (isset($AirtableData[0]->{'Vendor Email'})) {

                $date = date('H:i:s');
                $pdf =  PDF::loadHTML($vendor_email_score_body)->setPaper('a4' )
                ->setWarnings(true);
                // dd(base64_encode($pdf->output()));
                $emails = explode(',', $AirtableData[0]->{'Vendor Email'});

                $message
                ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
                ->to($emails, "{$AirtableData[0]->CRM}")
                ->subject("SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}")
                ->attachData($pdf->output(), "SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}".".pdf");
                // die;
              } else {
                dd("here");
                $message
                ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
                ->to("dnorgarb@gmail.com", "No email record in DB for this referral")
                ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
                ->subject("No vendor email record in DB for " . "{$AirtableData[0]->CRM}");
              }
            });

          } elseif (isset($scores)) {
            Mail::send("Email.EmailToVendorFromUserEmail",
            [
              "scores" => $scores,
              "data" => $data
            ], function ($message) use ($email, $AirtableData, &$scores, $data) {
              if (isset($AirtableData[0]->{'Vendor Email'})) {

                // $date = date('H:i:s');
                // $pdf =  PDF::loadHTML($scores)->setPaper('a4' )
                // ->setWarnings(true);
                //
                $emails = explode(',', $AirtableData[0]->{'Vendor Email'});
                $emails = "dnorgarb@gmail.com";
                $message
                ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
                ->to($emails, "{$AirtableData[0]->CRM}")
                ->subject("SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}");
                // ->attachData($pdf->output(), "SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}".".pdf");
                // die;
              } else {
                $message
                ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
                ->to("dnorgarb@gmail.com", "No email record in DB for this referral")
                ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
                ->subject("No vendor email record in DB for " . "{$AirtableData[0]->CRM}");
              }
            });
          }

            if (isset($email)) {
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


            if (isset($AirtableData[0]->{'Column 10'})) {
                return redirect("{$AirtableData[0]->{'Column 10'}}");
            } elseif (isset($AirtableData[0]->{'Visit Website Button'})) {
                return redirect("{$AirtableData[0]->{'Visit Website Button'}}");
            } else {
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    public function getEmailsSent()
    {
      $emailsSent = DB::table('email_log')->get();
      // dd($emailsSent);
      return view('emails-sent', compact("emailsSent"));

    }
}
