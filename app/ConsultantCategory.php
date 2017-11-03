<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class ConsultantCategory extends Model
{
  use LogsActivity;

    protected $fillable = [
    "name",
    "subheading",
  ];

    public function questions()
    {
        return $this->hasMany('App\ConsultantQuestion');
    }
}
