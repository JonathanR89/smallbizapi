<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    protected $fillable = [
      "name",
      "surname",
      "company",
      "email",
      "profile_pic",
      "country",
      "phone_number",
      "description",
      "is_active",
      "specialises_in",
    ];
}
