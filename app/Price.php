<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Price extends Model
{
    protected $table = "prices";
    protected $primaryKey = "price_id";
    protected $guarded = [];

    public function stock ()
    {
     return $this->belongsTo('App\Stock','stock_id','stock_id');
    }

    public static function getLatestPrice($id){
        $data = DB::table('prices as a')
            ->join('units as b', 'a.unit_id', 'b.unit_id')
            ->where('a.stock_id', $id)
            ->latest('a.created_at')
            ->first();
        if($data){
            return $data;
        }
        return 0;
    }
}
