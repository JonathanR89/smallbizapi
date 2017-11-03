<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class UserLog extends Model
{
  use LogsActivity;

    protected $fillable = [
      "page",
      "time_spent",
      "user_id",
      "page_to",
      "page_from",
      "user_uid",
    ];
}
