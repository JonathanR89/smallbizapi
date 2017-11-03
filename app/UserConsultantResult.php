<?php

namespace App;


use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class UserConsultantResult extends Model
{
  use LogsActivity;

    protected $fillable = [
    "submission_id",
    "user_id",
    "consultant",
    "consultant_id",
  ];
}
