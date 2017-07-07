<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Metric;

class QuestionnaireController extends Controller
{
    public function index($value='')
    {
      return Metric::all();
    }
}
