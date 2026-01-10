<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payment";

   protected $fillable = ['user_id','payment_id','amount','currency','method','status'];
   
   public function getcustomer(){
    return $this->belongsTo(User::class,'user_id','id');
   } 
}
