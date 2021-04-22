<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    
    protected $table = "stocks";
    protected $primaryKey = "stock_id";
    protected $guarded = [];
   

    public function products(){
        return $this->belongsTo('App\Product');
    }

    public function orderLines(){
        return $this->hasMany('App\Orderline');
    }

    public function prices(){
        return $this->hasMany('App\Price','stock_id','stock_id');
    }

    public function seller(){
        return $this->belongsTo('App\Seller','seller_id','seller_id' );
    }

    public static function countActiveStock(){
        $data=Stock::where('deleted_at', null)->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public static function getQty($id){
        // GET QUANTITIES
        $stock_qty = Stock::find($id)->qty_added;
        $order_qty = OrderLine::where('stock_id', $id)->sum('order_qty');
        $remaining_qty = $stock_qty - $order_qty;
        
        $data = (object)[];
        $data->stock = $stock_qty;
        $data->order = $order_qty;
        $data->remaining = $remaining_qty;
        return $data;
    }

}
