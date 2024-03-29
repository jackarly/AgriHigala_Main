<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{   
   use Notifiable;
   use SoftDeletes;

   protected $table = 'users';
   protected $primaryKey = "user_id";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $guarded = [];
   //  protected $fillable = [
   //      'user_id'
   //  ];

   /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $hidden = [
      'password', 'remember_token',
   ];

   /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */protected $casts = [
       'email_verified_at' => 'datetime',
   ];

   public function rider(){
      return $this->hasOne('App\Rider','user_id','user_id');
   }

   public function seller(){
      return $this->hasOne(Seller::class,'user_id','user_id');
   }

   public function buyer(){
      return $this->hasOne(Buyer::class,'user_id','user_id');
   }

   public function admin(){
      return $this->hasOne('App\Admin', 'user_id', 'user_id');
   }
}
