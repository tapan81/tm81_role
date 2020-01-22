<?php

namespace tapanmandal81\tm81_role\Models;

use Illuminate\Database\Eloquent\Model;

class User_meta extends Model
{
    protected $fillable = [
        'user_id', 'meta_key', 'meta_value',
    ];
}
