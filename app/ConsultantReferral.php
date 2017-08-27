<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantReferral extends Model
{
    protected $fillable = [
    "submission_id",
    "consultant_id",
    "consultant_url",
  ];
}
