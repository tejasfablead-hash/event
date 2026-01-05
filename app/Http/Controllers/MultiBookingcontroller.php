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
        return view('book.view', compact('book'));
    }

    public function index()
    {
        $customer = User::all();
        $event = Event::all();
        return view('book.insert', compact(['customer', 'event']));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'customer'  => 'required',
            'event.*'     => 'required',
            'eventdate.*' => 'required',
            'qty.*'       => 'required|numeric|min:1',
            'price.*'=>'required'

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

        foreach ($request->event as $key => $value) {

            $startdate = null;
            $enddate = null;

            if (!empty($request->eventdate[$key])) {
                $dates = explode(',', $request->eventdate[$key]);
                $startdate = $dates[0] ?? null;
                $enddate = $dates[1] ?? $startdate;
            }

            Booking::create([
                'customer'   => $request->customer,
                'event'      => $request->event[$key],
                'start_date' => $startdate,
                'end_date'   => $enddate,
                'qty'        => $request->qty[$key],
                'total'=>$request->price[$key],
                'grandtotal'=>$request->total[$key]
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Event Booking Successfully',
        ]);
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
            'qty'    => $request->qty,
            'status' => $request->status
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
}
