<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $customer = User::count();
        $event = Event::count();
        $book = Booking::count();
        $pending = Booking::where('status','pending')->count();
        return view('dashboard', compact('customer', 'event', 'book','pending'));
    }

    public function event()
    {
        $bookings = Booking::with(['getcustomer', 'getevent'])->get();

        $events = [];

        foreach ($bookings as $row) {
            $events[] = [
                'id'    => $row->id,
                'title' => $row->getevent->title . ' (' . $row->getcustomer->name . ')',
                'start' => $row->start_date->format('Y-m-d'),
                'end'   => $row->end_date
                    ? $row->end_date->addDay()->format('Y-m-d')
                    : $row->start_date->format('Y-m-d'),

                'extendedProps' => [
                    'customer' => $row->getcustomer->name,
                    'event'    => $row->getevent->title,
                    'qty'      => $row->qty,
                    'status'   => $row->status,
                    'city'  =>$row->getevent->getcity->city_name
                ],

                'color' => $row->status === 'pending' ? '#f5c57eff' : '#b1ecb3ff',
            ];
        }



        return response()->json($events);
    }
}
