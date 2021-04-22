<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Seller as Authenticatable;
class Seller extends Model
{
    protected $table = "sellers";
    protected $primaryKey = "seller_id";
    
    
    protected $guarded = [];

    // protected $fillable=[
    //     'organization_name','email','mobile_number','street','barangay','schedule_online_time',
    //     'seller_image','seller_description','user_id'
    // ];
    public function user(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }

    public function riders(){
        return $this->hasMany('App\Rider');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

    public function org(){
        return $this->belongsTo(Org::class,'org_id','org_id');
    }

    public function stocks(){
        return $this->hasMany('App\Stock','seller_id','seller_id');
    }

    public static function countActiveSeller(){
        $data = DB::table('users as a')
            ->join('sellers as b', 'a.user_id', '=', 'b.user_id')
            ->where('a.deleted_at', null)
            ->count();

        if($data){
            return $data;
        }
        return 0;
    }

    public static function getActiveSeller(){
        $data = DB::table('users as a')
            ->join('sellers as b', 'a.user_id', 'b.user_id')
            ->select('b.seller_id', 'a.username', 'a.f_name', 'a.l_name')
            ->where('a.deleted_at', null)
            ->orderBy('a.f_name')
            ->orderBy('a.l_name')
            ->get();

        if($data){
            return $data;
        }
        return false;
    }
}
