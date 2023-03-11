<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnDetail extends Model
{
    protected $table = 'return_details';
    protected $fillable = ['srn_no', 'product', 'qty', 'cost_price', 'sell_price'];

    public function products(){
        return $this->hasMany(ProductModel::class, 'id','product');
    }
}
