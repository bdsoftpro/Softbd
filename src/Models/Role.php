<?php

namespace SBD\Softbd\Models;

use Illuminate\Database\Eloquent\Model;
use SBD\Softbd\Facades\Softbd;

class Role extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(Softbd::modelClass('User'), 'user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Softbd::modelClass('Permission'));
    }
}
