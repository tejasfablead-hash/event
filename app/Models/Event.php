<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = "event";

   protected $fillable = ['title','desc','category','city','capacity','price','image'];
   
   protected $casts = [
    'image' => 'array',
];
public function getcity(){
    return $this->belongsTo(City::class,'city','id');
}
public function getcategory(){
    return $this->belongsTo(Category::class,'category','id');
}
public function getbooking(){
    return $this->hasOne(Booking::class,'event','id');
   }

}
