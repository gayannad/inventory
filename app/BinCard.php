<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BinCard extends Model
{
    protected $table = 'bin_card';


    public static function addBinCardRecord($locid, $type, $reference, $product, $qty)
    {
        $bin_card = new BinCard();
        $bin_card->location = $locid;
        $bin_card->type = $type;
        $bin_card->reference = $reference;
        $bin_card->product = $product;
        $bin_card->qty = $qty;
        $bin_card->save();
    }

    public static function getBinCardDetail($locid, $product)
    {
        $bins = DB::table('bin_card as b')
            ->join('products as p', 'b.product', '=', 'p.id')
            ->select('b.product', 'b.qty', 'b.type', 'b.reference', 'b.created_at as date')
            ->where('b.location', $locid)
            ->where('b.product', $product)
            ->orderBy('b.created_at','ASC')
            ->get();

        return $bins;
    }


}
