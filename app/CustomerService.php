<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerService extends Model
{
    use SoftDeletes;
    
    protected $table = "customer_services";
    protected $primaryKey = "customer_service_id";
    protected $guarded = [];

    // public static function getCustomerMessages($id){
    //     $data = DB::table('customer_services as a')
    //         ->leftJoin('users as b', 'a.user_id', 'b.user_id')
    //         ->select('a.*','a.created_at as announcement_created_at', 'b.f_name', 'b.l_name', 'b.username')
    //         ->latest('announcement_created_at')
    //         ->where('a.user_id', $id)

    //         ->get();

    //     if (count($data)){
    //         return $data;
    //     }
    //     return 0;
    // }
}