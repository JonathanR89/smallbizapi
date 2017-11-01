<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmissionPriceRange extends Model
{
    protected $fillable = [
      "price_range",
  ];

  public function vendor()
  {
      return  $this->hasOne('App\Package', 'user_size_id');
  }
}
