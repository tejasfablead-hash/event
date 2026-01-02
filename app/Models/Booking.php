<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
     protected $table = "booking";

   protected $fillable = ['customer','event','start_date','end_date','qty','status'];

   protected $casts = [
    'start_date' => 'datetime',
    'end_date'=>'datetime'
];
   public function getcustomer(){
    return $this->belongsTo(User::class,'customer','id');
   }
public function getevent(){
    return $this->belongsTo(Event::class,'event','id');
   }
}
