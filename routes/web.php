<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MultiBookingcontroller;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\Author;

Route::get('/app', function () {
    return view('index');
});



Route::get('/registration', [AuthController::class,'register'])->name('RegisterPage');
Route::post('/register', [AuthController::class,'store'])->name('RegisterAddPage');
Route::get('/', [AuthController::class,'login'])->name('LoginPage');
Route::post('/login', [AuthController::class,'match'])->name('LoginMatchPage');
Route::get('/profile', [AuthController::class,'profile'])->name('ProfilePage');
Route::post('/logout', [AuthController::class,'logout'])->name('LogoutPage');

Route::get('/event',[EventController::class,'index'])->name('EventAddPage');
Route::post('/event-add',[EventController::class,'store'])->name('EventStorePage');
Route::get('/events-edit/{id}',[EventController::class,'edit'])->name('EditEventPage');
Route::post('/event-upate',[EventController::class,'update'])->name('EventUpdatePage');
Route::get('/event-view',[EventController::class,'view'])->name('EventViewPage');
Route::get('/event-details/{id}',[EventController::class,'eventdetail'])->name('EventDetailPage');
Route::get('/events-delete/{id}',[EventController::class,'delete'])->name('DeleteEventPage');


Route::post('/event-book',[Bookingcontroller::class,'book'])->name('EventsBookPage');
Route::get('/eventbook-view',[Bookingcontroller::class,'view'])->name('EventsBookViewPage');
Route::get('/eventbook-details/{id}',[Bookingcontroller::class,'bookdetail'])->name('EventsBookDetailPage');
Route::get('/eventbook-edit/{id}',[Bookingcontroller::class,'edit'])->name('EventsBookEditPage');
Route::post('/event-book-update',[Bookingcontroller::class,'update'])->name('EventsBookUpdatePage');
Route::get('/eventbook-delete/{id}',[Bookingcontroller::class,'delete'])->name('EventsBookEditPage');


Route::get('/event-booking',[MultiBookingcontroller::class,'index'])->name('EventsIndexPage');
Route::post('/event-booking-multiple',[MultiBookingcontroller::class,'store'])->name('EventsStorePage');


Route::get('/dashboard', [DashboardController::class,'dashboard'])->name('DashboardPage');

Route::get('/dashboard/event', [DashboardController::class,'event'])->name('DashboardEventPage');
