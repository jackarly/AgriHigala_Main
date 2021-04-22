<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SRP extends Model
{
    protected $table ="srp";
    protected $primaryKey = "srp_id";
    protected $guarded = [];
    
    public function product() {
        return $this->belongsTo('App\Product','product_id','product_id');
    }

    public static function getLatestSRP($id){
        $data = DB::table('srp as a')
            ->join('units as b', 'a.unit_id', 'b.unit_id')
            ->where('a.product_id', $id)
            ->latest('a.created_at')
            ->first();
        if($data){
            return $data;
        }
        return 0;
    }
}
