<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Submission extends Model
{
  use LogsActivity;

    protected function getDateFormat()
    {
      return 'U';
    }
}
