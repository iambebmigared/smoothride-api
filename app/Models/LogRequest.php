<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogRequest extends Model
{
    protected $fillable = [
       'user_id','userType', 'reason','trip_id'
    ];

}
