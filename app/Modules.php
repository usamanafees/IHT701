<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $table = 'modules';
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

}
