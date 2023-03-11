<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public static function brandSave($data)
    {

        if ($data != null && $data != '') {
            $brand = new Brand();
            $brand->brand = $data;
            $brand->status = 1;
            $brand->save();
        }
    }
}
