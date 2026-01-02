<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Boot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    

    public function book(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'startdate' => 'required|date|after:today',
            'enddate' => 'required|date|after:today,startdate',
            'qty' => 'required|numeric'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
                'message' => 'All Fields Are Mandetory'
            ], 422);
        }
        $data = Booking::create([
            'customer' => $request->customer,
            'event' => $request->event,
            'start_date' => $request->startdate,
            'end_date' => $request->enddate,
            'qty' => $request->qty
        ]);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Event Booking Successfully',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Event Not Booking..'
            ]);
        }
    }

    public function view()
    {
        $book = Booking::all();
        return view('book.view', compact('book'));
    }

    public function bookdetail($id)
    {
        $data = Booking::where('id', $id)->first();
        return view('book.bookingdetails', compact('data'));
    }

    public function edit($id)
    {
        $book = Booking::all();
        $single = Booking::where('id', $id)->first();
        return view('book.view', compact(['book', 'single']));
    }

    public function update(Request $request)
    {
        
        $data = Booking::where('id', $request->id)->first();

        $validate = Validator::make($request->all(), [
            'status' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ], 422);
        }

        $result = $data->update([
           
            'status' => $request->status
        ]);
        if ($result) {
            return response()->json([
                'status' => true,
                'message' => ' Booking Status Updated Successfully',
                'data' => $result
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => ' Booking Status Not Update.'
            ]);
        }
    }
    public function delete($id){
        $data = Booking::where('id',$id)->first();
        if(!$data){
             return response()->json([
                'status' => false,
                'message' => 'Record Not Available'
            ]);
        }
        $data->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Record Deleted Successfully'
        ]);
    }
}
