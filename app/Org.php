<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Org extends Model
{
    protected $table="orgs";

    protected $primaryKey = "org_id";
    protected $guarded =[];


    public function brgy(){
       return $this->belongsTo(Brgy::class,'brgy_id','brgy_id');
    }

    public function seller(){
        return $this->hasOne(Seller::class,'org_id','org_id');
    }

    public static function findAvailableOrgs(){
        $countOrg = DB::table('orgs as a')
            ->leftJoin('sellers as b', 'a.org_id', 'b.org_id')
            ->whereNull('b.org_id')
            ->count();

        if($countOrg){
            $data = DB::table('orgs as a')
                ->leftJoin('sellers as b', 'a.org_id', 'b.org_id')
                ->whereNull('b.org_id')
                ->select('a.org_id', 'a.org_name')
                ->get();
            return $data;
        }
        return false;
        
    }
}
