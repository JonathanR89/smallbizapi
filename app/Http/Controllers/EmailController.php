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
        // dd($vendor);

        // dd($request->all());
        $email =  $request->input("email");
        $uri  = $request->input("uri");
        $host  = $request->input("host");
        $email_score_body = urldecode($request->input("email_score_body"));
        $vendor_email = $request->input("vendor_email");
        $results =  urldecode($request->input("results"));
        $body = file_get_contents("http://$host.$uri");
        $email_score_body = json_decode($email_score_body);
        $AirtableData = Airtable::getEntryByPackageName($vendor);
        if ($vendor) {

        // dd($AirtableData);
        Mail::send("Email.EmailToVendor",
            [
              "email_score_body" => $email_score_body,
              "user_view_body" => $body
            ], function ($message) use ($email, $AirtableData, $vendor_email) {
                // dd($AirtableData[0]->{'Vendor Email'});
                $message
              ->from("dev@devswebdev.com", "SmallBizCRM.com")
              ->to("{$AirtableData[0]->{'Vendor Email'}}", "{$AirtableData[0]->CRM}")
              ->subject("SmallBizCRM CRM Finder refferal " . "{$AirtableData[0]->CRM}");
            });
            if ($AirtableData[0]->{'Column 10'}) {
                // dd($AirtableData[0]->{'Column 10'});
            return redirect("{$AirtableData[0]->{'Column 10'}}");
            }
        }
        return redirect()->back();
    }
}
