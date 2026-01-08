<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function view()
    {
        if (Auth::check()) {
            $event = Event::all();
            return view('event.view', compact('event'));
        } else {
            return view('pages.login');
        }
    }
    public function dashboard()
    {
        if (Auth::check()) {
            $event = Event::all();
            $customer = User::count();
            $events = Event::count();
            $book = Booking::count();
            $pending = Booking::where('status', 'pending')->count();
            return view('dashboard', compact('customer', 'events', 'event', 'book', 'pending'));
        } else {
            return view('pages.login');
        }
    }

    public function events()
    {
        if (Auth::check()) {
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
                        'title' => $eventModel->title . ' (' . $booking->getcustomer->name . ')',
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
        } else {
            return view('pages.login');
        }
    }
}
