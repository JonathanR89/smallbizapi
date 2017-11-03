<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class PackageMetric extends Model
{
  use LogsActivity;

    protected $table = 'packages_metrics';

    protected $fillable = [
      "score",
    ];

    public $timestamps = false;
}
