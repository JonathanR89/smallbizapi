<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Metric extends Model
{
  use LogsActivity;

    protected $fillable = [];

    public function scores()
    {
        return $this->hasMany(PackageMetric::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
