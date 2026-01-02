<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
   protected $table = "city";

   protected $fillable = ['city_name'];

   public function getevent(){
    return $this->hasOne(Event::class,'city','id');
}
}
