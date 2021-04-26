<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inbox extends Model
{
    protected $table = "inbox";
    protected $primaryKey = "inbox_id";
    protected $guarded = [];
    
    public function buyers()
    {
        return $this->belongsTo('App\Buyer');
    }

    public function sellers()
    {
        return $this->belongsTo('App\Seller');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }


    public static function sellerInbox($id)
    {
        $buyer_message = DB::table('messages as a')
        ->join('inbox as b','b.inbox_id','a.inbox_id')
        ->where('b.inbox_id',$id)
        ->latest('a.created_at')
        ->get();
        // dd($buyer_message);
            return $buyer_message;
    }

    public static function getCreatedAt($id)
    {
        $buyer_message = DB::table('messages as a')
        ->join('inbox as b','b.inbox_id','a.inbox_id')
        ->where('b.inbox_id',$id)
        ->select('a.created_at')
        ->latest('a.created_at')
        ->first();    

        return $buyer_message->created_at;
    }

    public static function countInboxMessages($id)
    {
        $data = DB::table('messages as a')
            ->join('inbox as b', 'a.inbox_id', 'b.inbox_id')
            ->where('a.inbox_id', $id)
            ->count();

        return $data;
    }

    public static function checkLastMessage($id)
    {
        $data = DB::table('messages as a')
            ->join('inbox as b', 'a.inbox_id', 'b.inbox_id')
            ->where('a.inbox_id', $id)
            ->select('a.created_at')
            ->latest('a.created_at')
            ->first();

        return $data;
    }

    // public static function getUserDetailsFromInbox($id){
    //     $data = DB::table('inbox as a')
    //         ->join('buyers as b', 'a.buyer_id', 'b.buyer_id')
    //         ->join('users as c', 'b.user_id', 'c.user_id')
    //         ->join('sellers as d', 'a.seller_id', 'd.seller_id')
    //         ->join('users as e', 'd.user_id', 'e.user_id')
    //         ->select('a.*', 'c.f_name as buyer_f_name', 'c.l_name as buyer_l_name', 'c.username as buyer_username', 'e.f_name as seller_f_name', 'e.l_name as seller_l_name', 'e.username as seller_username')
    //         ->get();
        
    //     if ($data){
    //         return $data;
    //     }
    //     return 0;
    // }
       
}
