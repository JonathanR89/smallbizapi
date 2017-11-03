<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class UserResult extends Model
{
  use LogsActivity;

    protected $fillable = [
      "submission_id",
      "user_id",
      "package_name",
      "package_id",
      "score",
    ];
}
