<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id');
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public static function getUser($user_id)
    {
        $user = DB::table('users')
            ->join('locations', 'users.locid', '=', 'locations.id')
            ->select('users.id', 'users.name as user_name', 'users.locid', 'locations.name as location_name', 'locations.telephone',
                'locations.email', 'locations.contact_person')->where('users.id', $user_id)->get()->first();

        return $user;
    }


    public static function updateUser($data)
    {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $id = $data['id'];
        $user = Auth::user()->id;

        DB::table('users')
            ->where('id', $id)
            ->update(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    public static function updateUserImage($data)
    {
        $img_url = $data['img_url'];
        $id = $data['id'];
        $user = Auth::user()->id;

        DB::table('users')
            ->where('id', $id)
            ->update(['img_url' => $img_url,'updated_at' => date('Y-m-d H:i:s')]);
    }
}
