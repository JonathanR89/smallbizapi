<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Airtable;

class EmailController extends Controller
{
    use Airtable;

    public function listener(Request $request)
    {
        $vendor = array_keys($request->all());
        // dd($request->all());
        $email =  $request->input("email");
        // dd($results);
        $results =  urldecode($request->input("results"));
        dd(json_decode($results));
        // dd(urlencode(urldecode(unserialize($results))));
        $AirtableData = Airtable::getEntryByPackageName($vendor[0]);
        // dd($AirtableData);
    }
}
