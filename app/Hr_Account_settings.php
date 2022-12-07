<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Hr_Account_settings extends Model
{
    protected $table = 'hr_account_settings';
    use SoftDeletes;

    public function User()
    {
        return $this->belongsTo('App\User','uid','id');
    }
}
