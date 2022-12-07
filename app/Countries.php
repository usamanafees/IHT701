<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'countries';
    protected $fillable = ['*'];
    public function SMSRate()
    {
        return $this->hasMany('App\SMSRate');
    }
}
