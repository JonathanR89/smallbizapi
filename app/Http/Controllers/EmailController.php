<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function listener(Request $request)
    {
        dd(array_keys($request->all()));
    }
}
