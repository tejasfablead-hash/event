<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
   protected $table = "booking";

   protected $fillable = ['customer', 'event', 'start_date', 'end_date', 'qty', 'status', 'total', 'grand_total'];

protected $casts = [
    'event'       => 'array',
    'qty'         => 'array',
    'price'       => 'array',
    'total'       => 'array',
    'start_date'  => 'array',
    'end_date'    => 'array',
    'grand_total' => 'float',
];
   public function getcustomer()
   {
      return $this->belongsTo(User::class, 'customer', 'id');
   }
   public function getevent()
   {
      return $this->belongsTo(Event::class, 'event', 'id');
   }
}
