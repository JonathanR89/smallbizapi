<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class SubmissionUserSize extends Model
{
  use LogsActivity;

    protected $fillable = [
    "user_size",
  ];
}
