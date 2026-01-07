<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $customer = User::count();
        $event = Event::count();
        $book = Booking::count();
        $pending = Booking::where('status', 'pending')->count();
        return view('dashboard', compact('customer', 'event', 'book', 'pending'));
    }

    public function events()
    {
        $bookings = Booking::with('getcustomer')->get();
        $events = [];

        foreach ($bookings as $booking) {
           
            $eventIds = (array) $booking->event;
            $dates    = (array) $booking->start_date;

            foreach ($eventIds as $index => $eventId) {

                if (!isset($dates[$index])) {
                    continue;
                }

                $eventModel = Event::find($eventId);
                if (!$eventModel) continue;

                $dateRange = $dates[$index];

                if (str_contains($dateRange, 'to')) {
                    [$start, $end] = array_map('trim', explode('to', $dateRange));
                } else {
                    $start = trim($dateRange);
                    $end   = trim($dateRange);
                }

                $events[] = [
                    'title' => $eventModel->title . ' (' . $booking->getcustomer->name. ')',
                    'start' => $start,
                    'end'   => date('Y-m-d', strtotime($end . ' +1 day')),

                    'extendedProps' => [
                        'customer' => $booking->getcustomer->name ?? 'N/A',
                        'event'    => $eventModel->title,
                        'qty' => $booking->qty[$index],
                        'status'   => ucfirst($booking->status),
                        'city'     => $booking->getevent->getcity->city_name ?? 'N/A',
                    ],

                    'backgroundColor' => $booking->status === 'confirmed'
                        ? '#28a745'
                        : '#ffc107',
                    'borderColor' => '#ffffffff'
                ];
            }
        }

        return response()->json($events);
    }

  
}
