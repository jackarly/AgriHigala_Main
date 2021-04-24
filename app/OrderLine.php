<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $table = "orderlines";
    protected $primaryKey = "orderline_id";
    protected $guarded=[];
    public function  stock()
    {
        return $this->belongsTo('App\Stock');

    }

    public function  order()
    {
        return $this->belongsTo('App\Order');

    }

    public static function getOrderQuantity($id){
        $data = OrderLine::where('order_id', $id)
            ->sum('order_qty');

        if($data){
            return $data;
        }
        return 0;
    }
}
