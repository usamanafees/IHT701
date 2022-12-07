<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','country_id','company_name','phone_no','access_modules','sms_cost','api_key','address','postal_code','location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function setPasswordAttribute($password)
    // {   
    //     $this->attributes['password'] = bcrypt($password);
    // }

    public function Invoices()
    {
        return $this->hasOne('App\Invoices', 'uid', 'id');
    }
    public function Subsidiaries()
    {
        return $this->hasOne('App\Subsidiaries');
    }
    public function AccountSettings()
    {
        return $this->hasOne('App\AccountSettings');
    }
    public function Hr_account_settings()
    {
        return $this->hasOne('App\Hr_Account_settings','uid','id');
    }
    public function Sender()
    {
        return $this->hasOne('App\SMS_Sender');
    }
    public function SMS()
    {
        return $this->hasMany('App\SMS');
    }
	public function InAppTransactions()
    {
        return $this->hasMany('App\InAppTransactions');
    }
    public function Team()
    {
        return $this->belongsToMany('App\Team');
    }
    public function dayoffrequests()
    {
        return $this->hasMany('App\DayssoffRequest','employee_id');
    }
}
