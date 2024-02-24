<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{

    public static function saveSupplier($data)
    {
        $user = Auth::user()->getAuthIdentifier();
        $supplier = new Supplier();
        $supplier->comapany_name = $data['company'];
        $supplier->contact_person = $data['contact_person'];
        $supplier->telephone = $data['telephone'];
        $supplier->fax = $data['fax'];
        $supplier->mobile = $data['mobile'];
        $supplier->email = $data['email'];
        $supplier->user_created = $user;
//        $supplier->category = $data['category'];

        $supplier->save();
    }

    public static function updateSupplier($data)
    {
        $user = Auth::user()->getAuthIdentifier();
        $comapany_name = $data['company'];
        $contact_person = $data['contact_person'];
        $telephone = $data['telephone'];
        $fax = $data['fax'];
        $mobile = $data['mobile'];
        $email = $data['email'];
        $id = $data['id'];

        DB::table('suppliers')
            ->where('id', $id)
            ->update(['comapany_name' => $comapany_name, 'contact_person' => $contact_person, 'telephone' => $telephone,
                'fax' => $fax, 'mobile' => $mobile, 'email' => $email, 'updated_at' => date('Y-m-d H:i:s'),'user_modified'=>$user]);
    }
}
