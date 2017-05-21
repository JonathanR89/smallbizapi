<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use Illuminate\Http\Request;
use App\Http\Traits\Airtable;

class EmailController extends Controller
{
    use Airtable;

    public function listener(Request $request)
    {
        $vendor = $request->input("vendor");
        $email =  $request->input("email");
        $name =  $request->input("user_name");
        $uri  = $request->input("uri");
        $host  = $request->input("host");
        $email_score_body = urldecode($request->input("email_score_body"));
        $results =  urldecode($request->input("results"));
        $email_score_body = json_decode($email_score_body);
        $AirtableData = Airtable::getEntryByPackageName($vendor);
        // dd($email_score_body);

        if (isset($vendor)) {
            Mail::send("Email.EmailToVendor",
            [
              "email_score_body" => $email_score_body
            ], function ($message) use ($email, $AirtableData, &$email_score_body) {
                if (isset($AirtableData[0]->{'Vendor Email'})) {

                // $test =  Excel::create('Crm Referral CSV', function($excel) use($email_score_body) {
                //     $excel->sheet('Crm Referral CSV', function($sheet) use($email_score_body) {
                //       $sheet->loadView('Email.EmailToVendor', ["email_score_body" => $email_score_body]);
                //     });
                //   })->export('pdf');
                //
                  // $pdf = PDF::loadHTML($email_score_body);
                  // $pdf = \App::make('snappy.pdf.wrapper');
                // $test =  PDF::loadHTML($email_score_body)
                // ->setPaper('a4')
                // ->setOrientation('landscape')
                // ->setOption('margin-bottom', 0)
                // ->save('crm-lead-from-SmallBizCRM.pdf');

                // $pdf = \App::make('snappy.pdf.wrapper');
                // $pdf->loadHTML('<h1>Test</h1>');

                  // $test = $pdf->pdf->download('crm-lead-from-SmallBizCRM.pdf');
                  // $test = $pdf->inline();
                  // $pdf = \App::make('dompdf.wrapper');
                  // $pdf->loadHTML('<h1>Test</h1>');
                  // $test = $pdf->stream();
                  // dd(htmlspecialchars($email_score_body));
                  $date = date('H:i:s');
                $test =  PDF::loadHTML(utf8_encode($email_score_body))->setPaper('a4' )
                ->setWarnings(true)
                ->save(public_path()."/crm-lead-from-SmallBizCRM-" . $date . ".pdf");

                  // dd($test);

                  $emails = explode(',', $AirtableData[0]->{'Vendor Email'});

                    $message
                    ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
                    ->to($emails, "{$AirtableData[0]->CRM}")
                    ->subject("SmallBizCRM CRM Finder referral " . "{$AirtableData[0]->CRM}")
                    ->attach(public_path()."/crm-lead-from-SmallBizCRM-" . $date . ".pdf");
                } else {
                    $message
                    ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
                    ->to("dnorgarb@gmail.com", "No email record in DB for this referral")
                    ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
                    ->subject("No vendor email record in DB for " . "{$AirtableData[0]->CRM}");
                }
            });

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
                ->subject( "Thank You " . $name . " " . $AirtableData[0]->CRM . " ". "Will be in contact with you shortly ");
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
