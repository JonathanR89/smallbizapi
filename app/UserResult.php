<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserResult extends Model
{
    protected $fillable = [
      "submission_id",
      "user_id",
      "package_name",
      "package_id",
      "score",
    ];
}
