<?php

namespace App\Http\Controllers;

use Mail;
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
        // $vendor_email = $request->input("vendor_email");
        // if (!isset($vendor_email)) {
        //   $vendor_email =
        // }
        $results =  urldecode($request->input("results"));
        $body = file_get_contents("http://$host.$uri");
        $email_score_body = json_decode($email_score_body);
        $AirtableData = Airtable::getEntryByPackageName($vendor);
        if (isset($vendor)) {
            // dd($AirtableData);
            Mail::send("Email.EmailToVendor",
            [
              "email_score_body" => $email_score_body,
              "user_view_body" => $body
            ], function ($message) use ($email, $AirtableData) {
                if (isset($AirtableData[0]->{'Vendor Email'})) {
                    $message
                    ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
                    ->to("{$AirtableData[0]->{'Vendor Email'}}", "{$AirtableData[0]->CRM}")
                    ->subject("SmallBizCRM CRM Finder refferal " . "{$AirtableData[0]->CRM}");
                } else {
                    $message
                    ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
                    ->to("dnorgarb@gmail.com", "No email record in DB for this referral")
                    // ->to("perry@gmail.com", "No email record in DB for this referral")
                    ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
                    // ->to("theresa@smallbizcrm.com", "No email record in DB for this referral")
                    ->subject("SmallBizCRM CRM Finder refferal " . "{$AirtableData[0]->CRM}");
                }
            });
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
}
