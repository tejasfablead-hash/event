<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\City;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $city = City::all();
        $category = Category::all();
        return view('event.insert', compact(['city', 'category']));
    }
    public function view()
    {
        $event = Event::all();
        return view('event.view', compact('event'));
    }
    public function eventdetail($id)
    {
        $data = Event::where('id', $id)->first();
        $result = Booking::whereJsonContains('event', (string)$id)->get();
 
        $eventBookings = [];

        foreach ($result as $value) {
            $event = (array)$value->event;
            $startdate = (array)$value->start_date;
            $enddate = (array)$value->end_date;
            $qtys = (array)$value->qty;
            $totals = (array)$value->total;
           
            foreach ($event as $key => $values) {
                if ($values == $id) {
                    $eventBookings[] = [
                        'id'  => $value->id,
                        'event'=>$event[$key],
                        'customer' => $value->getcustomer->name,
                        'start_date'  => $startdate[$key] ?? null,
                        'end_date'    => $enddate[$key] ?? null,
                        'qty'         => $qtys[$key] ?? 0,
                        'total'       => ($totals[$key]*$qtys[$key]) ?? 0,
                        'status'      => $value->status,
                    ];
                }
            }
        }
        return view('event.eventdetail', compact(['data', 'eventBookings']));
    }

    public function store(Request $request)
    {
       
        $validate = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'city' => 'required',
                'capacity' => 'required|numeric',
                'category' => 'required',
                'price' => 'required|numeric',
                'image' => 'required|array',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif'
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
                'message' => 'All Fields Are Mandetory'
            ], 422);
        }

        $path = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $path[] = $file->store('event', 'public');
            }
        }
        $data = Event::create([
            'title' => $request->title,
            'desc' => $request->description,
            'category' => $request->category,
            'city' => $request->city,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'image' => json_encode($path)
        ]);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Event Created Successfully',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Event Not Created..'
            ]);
        }
    }

    public function edit($id)
    {
        $city = City::all();
        $category = Category::all();
        $event = Event::where('id', $id)->first();
        return view('event.update', compact(['city', 'category', 'event']));
    }

    public function update(Request $request)
    {
        $event = Event::findOrFail($request->id);

        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'city' => 'required',
            'capacity' => 'required|numeric',
            'category' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ], 422);
        }

        $path = json_decode($event->image ?? '[]', true);

        if ($request->hasFile('image')) {

            foreach ($path as $oldFile) {
                Storage::disk('public')->delete($oldFile);
            }

            $path = [];
            foreach ($request->file('image') as $file) {
                $path[] = $file->store('event', 'public');
            }
        }

        $event->update([
            'title' => $request->title,
            'desc' => $request->description,
            'category' => $request->category,
            'city' => $request->city,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'image' => json_encode($path),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Event Updated Successfully',
        ]);
    }
    public function delete($id)
    {
        $delete = Event::where('id', $id)->first();
        $delete->image;

        if (!$delete) {
            return response()->json([
                'status' => false,
                'message' => 'Record Not Available'
            ]);
        }

        if (!empty($delete->image)) {
            $images = json_decode($delete->image ?? '[]', true);
            if (is_array($images)) {
                foreach ($images as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }
            } else {
                Storage::disk('public')->delete($delete->image);
            }
        }
        $delete->delete();
        return response()->json([
            'status' => true,
            'message' => 'Record Deleted Successfully'
        ], 200);
    }
}
