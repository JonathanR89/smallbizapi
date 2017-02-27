<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    protected $fillable = [];

    public function scores()
    {
        return $this->hasMany(PackageMetric::class);
    }
}
