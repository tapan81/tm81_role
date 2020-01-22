<?php

namespace tapanmandal81\tm81_role\Models;

use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{
    protected $fillable = [
         'user_id', 'role_id',
    ];
	
	public $timestamps = false;
}
