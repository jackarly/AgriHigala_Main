<?php

namespace App

use Illuminate\Database\Eloquent\Model;

class Brgy extends Model
{
    protected $table="brgys";

    protected $primaryKey = "brgy_id";
    protected $guarded =[];


    public function buyer()
    {
        return $this->hasOne(Buyer::class,'brgy_id','brgy_id');
    }

    public function orgs()
    {
        return $this->hasMany(Org::class,'brgy_id','brgy_id');
    }

    public function stock()
    {
        return $this->hasOne('App\Stock','brgy_id','brgy_id');
    }
}
