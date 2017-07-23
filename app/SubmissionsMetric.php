<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmissionsMetric extends Model
{
    public $timestamps = false;

    protected $fillable = [
    "submission_id",
    "metric_id",
    "score",
    "created",
  ];
}
