<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Submission extends Model
{
  use LogsActivity;

  // protected $dates = [
  //   'created',
  //   'modified',
  // ];

  public $appends = [
    'created_at'
  ];

  protected $casts = [
    'created_at' => 'datetime',
  ];

  public function getCreatedAtAttribute()
  {
    // dd($this->attributes['created']);
    return \Carbon\Carbon::createFromTimestamp($this->attributes['created'])->toDateTimeString();
  }

    // protected function getDateFormat()
    // {
    //   return 'Y-m-d H:i:s';
    // }

    // protected $dateFormat =  'Y-m-d H:i:s';
    protected $dateFormat = 'U';


}
