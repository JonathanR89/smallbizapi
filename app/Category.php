<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
  use LogsActivity;

    public function metrics()
    {
        return $this->belongsToMany('App\Metric');
    }
}
