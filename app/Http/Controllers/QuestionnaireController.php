<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Metric;
use App\Category;

class QuestionnaireController extends Controller
{
    public function getMetrics($page = null)
    {
      $metrics = Metric::paginate(5);
      return $metrics;
    }

    public function getCategories($page = null)
    {
      $categorys = Category::all();
      return $categorys;
    }
}
