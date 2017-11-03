<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Consultant extends Model
{
  use LogsActivity;

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
