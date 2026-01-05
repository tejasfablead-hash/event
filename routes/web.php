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



Route::controller(AuthController::class)->group(function () {
    // Registration Routes
    Route::get('/registration', 'register')->name('RegisterPage');
    Route::post('/register', 'store')->name('RegisterAddPage');

    // Authentication Routes
    Route::get('/', 'login')->name('LoginPage');
    Route::post('/login', 'match')->name('LoginMatchPage');

    // Profile Routes
    Route::get('/profile', 'profile')->name('ProfilePage');
    Route::get('/profile-edit', 'edit')->name('ProfileEditPage');
    Route::post('/profile-update', 'update')->name('ProfileUpdatePage');

    Route::post('/logout', 'logout')->name('LogoutPage');
});


Route::controller(EventController::class)->group(function () {
    Route::get('/event', 'index')->name('EventAddPage');
    Route::post('/event-add', 'store')->name('EventStorePage');
    Route::get('/events-edit/{id}', 'edit')->name('EditEventPage');
    Route::post('/event-upate', 'update')->name('EventUpdatePage');
    Route::get('/event-view', 'view')->name('EventViewPage');
    Route::get('/event-details/{id}', 'eventdetail')->name('EventDetailPage');
    Route::get('/events-delete/{id}', 'delete')->name('DeleteEventPage');
});


Route::controller(Bookingcontroller::class)->group(function(){
Route::post('/event-book','book')->name('EventsBookPage');
Route::get('/eventbook-details/{id}','bookdetail')->name('EventsBookDetailPage');
Route::get('/eventbook-edit/{id}','edit')->name('EventsBookEditPage');
Route::post('/event-book-update','update')->name('EventsBookUpdatePage');
});

Route::controller(MultiBookingcontroller::class)->group(function () {
    Route::get('/event-booking', 'index')->name('EventsIndexPage');
    Route::post('/event-booking-multiple', 'store')->name('EventsStorePage');
    Route::get('/eventsbook-edit/{id}', 'edit')->name('EventsMultiBookEditPage');
    Route::post('/event-book-update', 'update')->name('EventsBooksUpdatePage');
    Route::get('/eventbook-view', 'view')->name('EventsBookViewPage');
    Route::get('/eventbook-delete/{id}', 'delete')->name('EventsBookEditPage');
});


Route::controller(DashboardController::class)->group(function () {
Route::get('/dashboard', 'dashboard')->name('DashboardPage');
Route::get('/dashboard/event', 'event')->name('DashboardEventPage');
}); 

