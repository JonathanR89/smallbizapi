<?php

namespace App\Http\Controllers;

use App\SubmissionIndustry;
use App\SubmissionPriceRange;
use App\SubmissionUserSize;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index($value='')
    {
        $industries = SubmissionIndustry::all();
        $userSizes = SubmissionUserSize::all();
        $priceRanges = SubmissionPriceRange::all();

        return view('forms.index', compact("industries", "userSizes", "priceRanges"));
    }
}
