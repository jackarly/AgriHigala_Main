<?php

namespace App

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table="units";

    protected $primaryKey = "unit_id";
    protected $guarded =[];


    public function product (){

        return $this->hasOne('App\Product');
    }
}
