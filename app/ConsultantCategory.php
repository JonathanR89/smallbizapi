<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantCategory extends Model
{
    protected $fillable = [
    "name",
    "subheading",
  ];

    public function questions()
    {
        return $this->hasMany('App\ConsultantQuestion');
    }
}
