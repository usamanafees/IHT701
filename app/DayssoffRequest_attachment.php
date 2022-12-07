<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayssoffRequest_attachment extends Model
{
    use SoftDeletes;
    protected $table = 'dayssoff_request_attachments';
    //dayssoff_request_attachments
    
    public function attachments()
    {
        return $this->belongsTo('App\DayssoffRequest','dayssoff_requests_id','id');
    }
}
