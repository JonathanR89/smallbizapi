<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class SubmissionPriceRange extends Model
{
  use LogsActivity;

    protected $fillable = [
      "price_range",
  ];

  public function vendor()
  {
      return  $this->hasOne('App\Package', 'user_size_id');
  }
}
