<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageMetric extends Model
{
    protected $table = 'packages_metrics';

    protected $fillable = [
      "score",
    ];

    public $timestamps = false;
}
