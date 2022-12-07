<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Credit_note extends Model
{
    use SoftDeletes;
    protected $table = 'credit_notes';
    //
}
