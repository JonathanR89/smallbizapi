<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubmission extends Model
{
    protected $fillable = [
    "email",
    "name" ,
    "price" ,
    "industry" ,
    "submission_id",
    "comments" ,
    "fname" ,
    "total_users" ,
    "infusionsoft_user_id"
  ];
}
