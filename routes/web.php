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


    Route::get('/user-details', 'user')->name('UsersPage');
    Route::get('/user-delete/{id}', 'delete')->name('DeleteUsersPage');
    Route::post('/logout', 'logout')->name('LogoutPage');
});

Route::controller(EventController::class)->group(function () {
    Route::get('/event', 'index')->name('EventAddPage');
    Route::post('/add-event', 'store')->name('EventStorePage');
    Route::get('/edit-events/{id}', 'edit')->name('EditEventPage');
    Route::post('/upate-event', 'update')->name('EventUpdatePage');
    Route::get('/view-event', 'view')->name('EventViewPage');
    Route::get('/event-details/{id}', 'eventdetail')->name('EventDetailPage');
    Route::get('/delete-events/{id}', 'delete')->name('DeleteEventPage');
});

Route::controller(Bookingcontroller::class)->group(function () {
    Route::post('/event-book', 'book')->name('EventsBookPage');
    Route::get('/eventbook-edit/{id}', 'edit')->name('EventsBookEditPage');
    Route::post('/event-book-update', 'update')->name('EventsBookUpdatePage');
});

Route::controller(MultiBookingcontroller::class)->group(function () {
    Route::get('/event-booking', 'index')->name('EventsIndexPage');
    Route::post('/add-event-booking', 'store')->name('EventsStorePage');
    Route::get('/edit-event-book/{id}', 'edit')->name('EventsMultiBookEditPage');
    Route::post('/update-eventbook', 'update')->name('EventsBooksUpdatePage');
    Route::get('/eventbook-view', 'view')->name('EventsBookViewPage');
    Route::get('/delete-eventbook/{id}', 'delete')->name('EventsBookdeletePage');
    Route::get('/eventbook-details/{id}', 'bookdetail')->name('EventsBookDetailPage');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('DashboardPage');
    Route::get('/dashboard/event', 'events')->name('DashboardEventPage');

});

