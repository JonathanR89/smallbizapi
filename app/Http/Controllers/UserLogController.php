<?php

namespace App\Http\Controllers;

use DB;
use App\Package;
use App\UserLog;
use App\SubmissionUserSize;
use App\SubmissionIndustry;
use Illuminate\Http\Request;
use App\Http\Traits\Airtable;
use App\SubmissionPriceRange;
use App\ImageUpload as ImageUploadModel;

class VendorController extends Controller
{
    public function logUser(Request $request)
    {
        UserLog::create($request->all());
    }
}
