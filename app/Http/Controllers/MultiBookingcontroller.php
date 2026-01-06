<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MultiBookingcontroller extends Controller
{
    public function view()
    {
        $book = Booking::latest()->get();
        $event = Event::pluck('title','id');
        return view('book.view', compact('book','event'));
    }

    public function index()
    {
        $customer = User::all();
        $event = Event::all();
        return view('book.insert', compact(['customer', 'event']));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer'      => 'required',
            'event.*'       => 'required',
            'eventdate.*'   => 'required',
            'qty.*'         => 'required|numeric|min:1',
        ], [
            'event.*.required'     => 'Event is required',
            'eventdate.*.required' => 'Event date is required',
            'qty.*.required'       => 'Quantity is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $startDate = [];
        $endDate   = [];
        foreach ($request->eventdate as $dateRange) {
            $dates = explode(',', $dateRange);
            $startDate[] = trim($dates[0]);
            $endDate[]   = trim($dates[1] ?? $dates[0]);
        }
        Booking::create([
            'customer'    => $request->customer,
            'event'       => $request->event,        // array
            'start_date'  => $startDate,             // array
            'end_date'    => $endDate,               // array
            'qty'         => $request->qty,            // array
            'status'      => 'pending',       // array
            'total'       => $request->price,          // array
            'grand_total' => $request->grandtotal[0],  // single value
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Event Booking Successfully',
        ]);
    }

    public function edit($id)
    {
        $event = Event::all();
        $single = Booking::where('id', $id)->first();
        return view('book.update', compact(['event', 'single']));
    }
    public function update(Request $request)
    {
        $data = Booking::where('id', $request->id)->first();

        $validate = Validator::make($request->all(), [
            'status' => 'required',
            'event' => 'required',
            'qty' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ], 422);
        }
        $result = $data->update([
            'event' => $request->event,
            'start_date' => $request->startdate,
            'end_date' => $request->enddate,
            'qty'    => $request->qty,
            'status' => $request->status,
            'total' => $request->total,
            'grandtotal' => $request->grandtotal
        ]);
        if ($result) {
            return response()->json([
                'status' => true,
                'message' => ' Booking  Updated Successfully',
                'data' => $result
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => ' Booking  Not Update.'
            ]);
        }
    }
    public function delete($id)
    {
        $data = Booking::where('id', $id)->first();
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Record Not Available'
            ]);
        }
        $data->delete();
        return response()->json([
            'status' => true,
            'message' => 'Record Deleted Successfully'
        ]);
    }
    public function bookdetail($id){
        $data = Booking::where('id',$id)->first();
         $event = Event::pluck('title','id');
        return view('book.bookingdetails',compact('data','event'));
    }
}
