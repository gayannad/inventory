<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @param $data
     */
    public static function saveCategory($data)
    {
        if ($data != null && $data != '') {
            $category = new Category();
            $category->category = $data;
            $category->status = 1;
            $category->save();
        }
    }
}
