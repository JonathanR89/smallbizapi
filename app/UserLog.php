<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = [
      "page",
      "time_spent",
      "user_id",
      "page_to",
      "page_from",
      "user_uid",
    ];
}
