<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Submission extends Model
{
  use LogsActivity;

  public $appends = [
    'created_at'
  ];

  protected $casts = [
    'created_at' => 'datetime',
  ];

  public function getCreatedAtAttribute()
  {
    return \Carbon\Carbon::createFromTimestamp($this->attributes['created'])->toDateTimeString();
  }

  protected $dateFormat = 'U';


}
