<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Location extends Model
{
    public static function saveLocation($data)
    {

        $user = Auth::user()->id;
        $location = new Location();

        $location->name = $data['name'];
        $location->contact_person = $data['contact_person'];
        $location->address = $data['address'];
        $location->telephone = $data['telephone'];
        $location->email = $data['email'];
        $location->type = $data['type'];
        $location->created_by = $user;
        $location->status = ACTIVE;
        $location->save();
    }

    public static function updateLocation($data)
    {
        $name = $data['name'];
        $contact_person = $data['contact_person'];
        $address = $data['address'];
        $telephone = $data['telephone'];
        $email = $data['email'];
        $id = $data['id'];
        $user = Auth::user()->id;

        DB::table('locations')
            ->where('id', $id)
            ->update(['name' => $name, 'telephone' => $telephone,
                    'email' => $email, 'contact_person' => $contact_person, 'address' => $address, 'updated_by' => $user,
                    'updated_at' => date('Y-m-d H:i:s')]
            );
    }
}
