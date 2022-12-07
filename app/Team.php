<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    protected $table = 'teams';
    use SoftDeletes;
    //
    public function User()
    {
        return $this->belongsToMany('App\User');
    }
}
