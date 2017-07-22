<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function metrics()
    {
        return $this->belongsToMany('App\Metric');
    }
}
