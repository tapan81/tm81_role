<?php

namespace tapanmandal81\tm81_role\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_role extends Model
{
    protected $fillable = [
        'role_id', 'permission_id',
    ];
	
	public $timestamps = false;
}
