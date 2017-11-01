<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmissionIndustry extends Model
{
    protected $fillable = [
      "industry_name"
    ];

    public function vendor()
    {
        return  $this->hasOne('App\Package', 'industry_id');
    }
}
