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

];

    public function scores()
    {
        return $this->hasMany(PackageMetric::class);
    }
}
