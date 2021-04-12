<?php

namespace App

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = "stocks";
    protected $primaryKey = "stock_id";
    protected $guarded = [];
   

    public function products ()
    {
        return $this->belongsTo('App\Product');
    }

    public function orderLines ()
    {
        return $this->hasMany('App\Orderline');
    }

    public function prices()
    {
        return $this->hasMany('App\Price','stock_id','stock_id');
    }

    public function seller()
    {

        return $this->belongsTo('App\Seller','seller_id','seller_id' );
    }

}
