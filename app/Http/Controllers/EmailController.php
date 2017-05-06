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
        // dd($request->all());
        $vendor = $request->input("vendor");
        $email =  $request->input("email");
        $uri  = $request->input("uri");
        $host  = $request->input("host");
        $email_score_body = $request->input("email_score_body");
        $vendor_email = $request->input("vendor_email");
        $results =  urldecode($request->input("results"));
        $body = file_get_contents("http://$host.$uri");
        $email_score_body = json_decode($email_score_body);
        $AirtableData = Airtable::getEntryByPackageName($vendor);
        // dd($AirtableData);
            Mail::send("Email.EmailToVendor",
            [
              "email_score_body" => $email_score_body,
              "user_view_body" => $body
            ], function ($message) use ($email, $AirtableData, $vendor_email) {
                $message
              ->from("dev@devswebdev.com", "SmallBizCRM.com")
              ->to("dev@devswebdev.com", "$AirtableData->CRM")
              ->subject("From SparkPost with ❤");
            });
        return redirect();
    }
}
