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
        return $this->hasMany(PackageMetric::class);
    }
}
