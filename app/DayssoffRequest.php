<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayssoffRequest extends Model
{
    use SoftDeletes;
    protected $table = 'dayssoff_requests';
    protected $fillable = ['start_date,end_date'];
    public function attachments()
    {
        return $this->hasMany('App\DayssoffRequest_attachment','dayssoff_requests_id','id');
    }
    public function users()
    {
        return $this->belongsTo('App\User','employee_id','id');
    }
    //
}
