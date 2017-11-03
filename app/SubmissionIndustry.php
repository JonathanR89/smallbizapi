<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class SubmissionIndustry extends Model
{
  use LogsActivity;

    protected $fillable = [
      "industry_name"
    ];

    public function vendor()
    {
        return  $this->hasOne('App\Package', 'industry_id');
    }
}
