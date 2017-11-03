<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ConsultantSubmissionMetric extends Model
{
  use LogsActivity;

    protected $fillable = [
    "question_name",
    "submission_id",
    "model",
    "question_id",
  ];
}
