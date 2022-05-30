<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
| All of authentication routes are defined with `Auth::routes()`.
|
| Use the list of routes below to see how they are defined:
| - Login page                  : route('login') -> auth/login.blade.php
| - Logout page                 : route('logout')
| - Registration page           : route('register') -> auth/register.blade.php
| - Forget password page        : route('password.request') -> auth/passwords/email.blade.php
| - Reset password page         : route('password.reset') -> auth/passwords/reset.blade.php
| - Email verification page     : route('verification.notice') -> auth/verify.blade.php
*/
Auth::routes(['verify' => true]);

// Go to home page
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Go to about page
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::middleware(['auth', 'verified'])->group(function () {
    // === Put all routes that need authentication and email verification here ===
    // Go to dashboard page
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

// TODO: All routes in below is not used the right method and params yet
// Go to vote page
Route::get('/vote', function () {
    return view('pages.vote');
})->name('vote');

// Go to add new event page
Route::get('/events/add', function () {
    return view('pages.event-add');
})->name('event.add');

// Go to detail event page
Route::get('/events/eventId', function () {
    return view('pages.event-detail');
})->name('event.detail');

// Go to result page
Route::get('/events/eventId/result', function () {
    return view('pages.result');
})->name('result');

// Go to voters page
Route::get('/events/eventId/voters', function () {
    return view('pages.voters');
})->name('voters');
