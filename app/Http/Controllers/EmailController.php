<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Airtable;

class EmailController extends Controller
{
    use Airtable;

    public function listener(Request $request)
    {
        // dd($request->all());
        $vendor = array_keys($request->all());
        $email =  $request->input("email");
        $uri  = $request->input("uri");
        $host  = $request->input("host");
        $email_score_body = $request->input("email_score_body");
        $results =  urldecode($request->input("results"));
        $body = file_get_contents("http://$host.$uri");
        $email_score_body = json_decode($email_score_body);
        // dd(json_decode($results));
        // dd(urlencode(urldecode(unserialize($results))));
        $AirtableData = Airtable::getEntryByPackageName($vendor[0]);
        // dd($AirtableData);
    }
}
