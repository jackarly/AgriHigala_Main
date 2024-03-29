<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table= "orders";
    protected $primaryKey = "order_id";
    protected $guarded = [];

    public function payment(){
        return $this->belongsTo('App\Payment');
    }

    public function buyer(){
        return $this->belongsTo('App\Buyer');
    }

    public function orderLines(){
        return $this->hasMany('App\OrderLine');
    }

    public function transaction(){
        return $this->hasOne('App\Transaction');
    }

    public function returnOrder(){
        return $this->hasOne('App\ReturnOrder', 'order_id', 'order_id');
    }
    
    public static function countOrder($order){

        switch($order)
        {
            case 'active':
                $data=Order::whereNull('delivered_at')->count();
                if($data){
                    return $data;
                }

            case 'complete':
                $data=Order::whereNotNull('delivered_at')->count();
                if($data){
                    return $data;
                }
                
            default:
                return 0;
        }
    }
    
}
