<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockModel extends Model
{

    protected $table = 'location_stock';

    public static function stockAvailable($location, $product, $stock_type)
    {
        $query = DB::table('location_stock  as l')
            ->select('*')
            ->where('l.location', $location)
            ->where('l.product', $product)
            ->where('l.stock_type', $stock_type)
            ->get();
        return count($query) > 0 ? true : false;

    }

    public static function addStock($location, $product, $stock_type, $qty)
    {

        $stock = new StockModel();
        $stock->location = $location;
        $stock->product = $product;
        $stock->qty = $qty;
        $stock->stock_type = $stock_type;
        $stock->save();

    }

    public static function updateStock($type, $location, $product, $stock_type, $qty)
    {

        if ($type == STOCK_PLUS) {
            DB::update('update location_stock set qty = qty + ? ,stock_type = ? WHERE product = ? AND location = ?'
                , array($qty, $stock_type, $product, $location));
        } elseif ($type == STOCK_MINUS) {
            DB::update('update location_stock set qty = qty - ?,stock_type = ? WHERE product = ? AND location = ?'
                , array($qty, $stock_type, $product, $location));
        }

    }
}
