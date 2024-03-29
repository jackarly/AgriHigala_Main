<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Buyer extends Model
{
    protected $table="buyers";

    protected $primaryKey = "buyer_id";
   
    protected $guarded =[];

    // protected $fillable=[
    //     'buyer_email', 'mobile_number','f_name','middle_name', 'last_name',
    //     'street', 'barangay',  'birth_date', 'gender',   'buyer_image',
    //     'valid_id',  'user_id'
    // ];

    public function user(){
        return $this->belongsTo(User::class,);
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function messeages(){
        return $this->hasMany('App\Message');
    }

    public function brgy(){
        return $this->belongsTo(Brgy::class);
    }

    public static function countActiveBuyer(){
        $data = DB::table('users as a')
            ->join('buyers as b', 'a.user_id', '=', 'b.user_id')
            ->where('a.deleted_at', null)
            ->count();

        if($data){
            return $data;
        }
        return 0;
    }

    public static function getBuyer($id){
        $data = DB::table('users as a')
            ->join('buyers as b', 'a.user_id', '=', 'b.user_id')
            ->where('b.buyer_id', $id)
            ->first();

        if($data){
            return $data;
        }
        return 0;
    }
}
