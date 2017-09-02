<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $fillable = [
      'name',
      'description',
      'created',
      'modified',
      'visit_website_url',
      'price',
      'price_id',
      'country',
      'town',
      'pricing_pm',
      'industry_suitable_for',
      'speciality',
      'target_market',
      'vendor_email',
      'test_email',
      'email_interested',
      'vertical',
      'has_trial_period',

    ];

    public function scores()
    {
        return $this->hasMany(PackageMetric::class);
    }
}
