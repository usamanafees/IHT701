<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthDayOff extends Model
{
    public function daysOff()
    {
        return $this->belongsTo('App\DayssoffRequest','daysOffRequest_id');
    }
}
