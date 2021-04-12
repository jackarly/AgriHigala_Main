<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    protected $table="orgs";

    protected $primaryKey = "org_id";
    protected $guarded =[];


    public function brgy()
    {
       
        return $this->belongsTo(Brgy::class,'brgy_id','brgy_id');
    }

    public function seller()
    {
        return $this->hasOne(Seller::class,'org_id','org_id');
    }
}
