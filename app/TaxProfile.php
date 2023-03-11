<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TaxProfile extends Model
{
    public static function getTaxValue($id)
    {
        $tax = DB::table('tax_profiles')->select('value')->where('id', $id)->get()->first();
        return $tax;
    }
}
