<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubmission extends Model
{
  protected  $fillable = [
    "email",
    "name" ,
    "price" ,
    "industry" ,
    "comments" ,
    "fname" ,
    "total_users" ,
  ];
}
