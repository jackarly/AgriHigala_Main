<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    use SoftDeletes;

    protected $table = "product_types";
    protected $primaryKey = "product_type_id";
    
    protected $guarded = [];

    public function products(){
        return $this->hasMany('App\Product');
    }
    
    public static function getCategoryList(){
        $data = ProductType::orderBy('product_type_name')->get();

        if ($data){
            return $data;
        }
        return 0;
    }
}
