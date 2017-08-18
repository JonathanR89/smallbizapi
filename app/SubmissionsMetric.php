<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmissionsMetric extends Model
{
    public $timestamps = false;

    public $primaryKey = ['submission_id, metric_id'];

    public $incrementing = false;

    protected $fillable = [
      "submission_id",
      "metric_id",
      "score",
      "created",
    ];
}
