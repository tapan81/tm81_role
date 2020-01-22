<?php

namespace tapanmandal81\tm81_role\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'display_name',
    ];
	
    public function permissions()
    {
        return $this->belongsToMany('tapanmandal81\tm81_role\Models\Permission');
    }	
	
	
}
