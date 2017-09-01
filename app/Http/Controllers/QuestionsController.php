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
        return view('forms.index');
    }
}
