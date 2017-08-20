<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantSubmissionMetric extends Model
{
    protected $fillable = [
    "question_name",
    "submission_id",
    "model",
    "question_id",
  ];
}
