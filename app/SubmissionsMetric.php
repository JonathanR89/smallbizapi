<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class SubmissionsMetric extends Model
{
  use LogsActivity;

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
