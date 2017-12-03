<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Package extends Model
{
  use LogsActivity;

    public $fillable = [
      'name',
      'description',
      'created',
      'modified',
      'visit_website_url',
      'read_review_url',
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
      'user_size_id',
      'industry_id',
      'image_id'
    ];

    public function image()
    {
        return $this->hasOne('App\ImageUpload', 'id', 'image_id');
    }

    public function scores()
    {
        return $this->hasMany('App\PackageMetric');
    }

    // Where ever this appeared in a users results
    public function submissions()
    {
        return $this->hasMany('App\SubmissionsPackage');
    }

    public function vertical()
    {
      return $this->hasOne('App\SubmissionIndustry');
    }

    public function industry()
    {
      return $this->hasOne('App\SubmissionIndustry', 'id', 'industry_id');
    }

    public function priceRange()
    {
      return $this->hasOne('App\SubmissionPriceRange', 'id', 'industry_id');
    }

}
