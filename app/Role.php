<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_role', 'role_id', 'user_id');
    }

    public static function saveRole($role, $description)
    {
        $new_role = new  Role();
        $new_role->name = $role;
        $new_role->description = $description;
        $new_role->save();
    }
}
