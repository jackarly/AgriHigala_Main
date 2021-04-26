<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    protected $table = "messages";
    protected $primaryKey = "message_id";
    protected $guarded = [];
    
    public function inbox(){
        return $this->belongsTo('App\Inbox');
    }

    public static function getMessage($id){
        $message = DB::table('messages as a')
        ->join('inbox as b','b.inbox_id','a.inbox_id')
        ->where('a.inbox_id',$id)
        ->latest('a.created_at')
        ->get();
        return $message;
    }
  
}
