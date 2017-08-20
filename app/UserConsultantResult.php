<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConsultantResult extends Model
{
    protected $fillable = [
    "submission_id",
    "user_id",
    "consultant",
    "consultant_id",
  ];
}
