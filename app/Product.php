<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $table = "products";
    protected $primaryKey = "product_id";
    protected $guarded = [];
   

    public function productType()
    {
        return $this->belongsTo('App\ProductType');

    }

    public function stocks()
    {
        return $this->hasMany('App\Stock');
        
    }

    public function srp()

    {
        return $this->hasMany('App\SRP','product_id','product_id');


    }

    public function unit()
    {
        return $this->hasOne('App\Unit');
    }

    public static function getProductByProductType($id){
        $data = Product::where('product_type_id', $id)->get();

        if ($data){
            return $data;
        }
        return false;
    }
}
