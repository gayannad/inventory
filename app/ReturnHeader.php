<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnHeader extends Model
{
    protected $table = 'return_headers';
    protected $fillable = ['supplier', 'remarks', 'total_cost','status'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    const RETURN_PENDING = 1;
    const RETURN_APPROVED = 2;
    const RETURN_REJECTED = 3;

    public function details(){
        return $this->hasMany(ReturnDetail::class, 'srn_no','id');
    }

    public function suppliers(){
        return $this->hasOne(SupplierModel::class, 'id','supplier');
    }
}
