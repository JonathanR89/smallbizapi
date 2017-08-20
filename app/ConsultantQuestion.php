<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantQuestion extends Model
{
    protected $fillable = [
      "question",
      "type",
      "category_id",
      "name",
    ];

    public function category()
    {
        return $this->belongsTo('App\ConsultantCategory');
    }
}
