<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/google/consent-screen', [App\Http\Controllers\GoogleCalender\GoogleCalenderController::class, 'getConsentScreen'])->name('google.consent-screen');

Route::get('/google/callback', [App\Http\Controllers\GoogleCalender\GoogleCalenderController::class, 'handleCallback']);

Route::get('/meeting/create', [App\Http\Controllers\Meeting\MeetingController::class, 'create'])->name('meeting.create');
Route::post('/meeting/store', [App\Http\Controllers\Meeting\MeetingController::class, 'store'])->name('meeting.store');

Route::get('/calender/fetch-events', [App\Http\Controllers\GoogleCalenderController::class, 'fetchCalendarData']);


