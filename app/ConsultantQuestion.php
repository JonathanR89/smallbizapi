<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ConsultantQuestion extends Model
{
  use LogsActivity;

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
