<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class ConsultantReferral extends Model
{
  use LogsActivity;

    protected $fillable = [
    "submission_id",
    "consultant_id",
    "consultant_url",
  ];
}
