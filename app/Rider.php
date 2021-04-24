<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rider extends Model
{
    protected $table = "riders";
    protected $primaryKey = "rider_id";
    protected $guarded = [];

    // protected $fillable=[
    //     'user_id','seller_id','first_name','middle_name','last_name','mobile_number','rider_image'
    // ];
   

    public function user(){
        return $this->belongsTo('App\User','user_id','user_id');
    }

    public function seller(){
        return $this->belongsTo('App\Seller');
    }

    public static function getRiderBySeller($id){
        $data = DB::table('riders as a')
            ->join('users as b', 'a.user_id', 'b.user_id')
            ->select('a.rider_id','a.seller_id', 'b.username', 'b.f_name', 'b.l_name', 'b.username')
            ->where('a.seller_id', $id)
            ->where('b.deleted_at', null)
            ->orderBy('b.f_name')
            ->orderBy('b.l_name')
            ->get();

        if($data){
            return $data;
        }
        return false;
    }


}
