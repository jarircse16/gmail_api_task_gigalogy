<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mailcontroller;

// Existing routes
//Route::get('/register', [Mailcontroller::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [Mailcontroller::class, 'store'])->name('register');

Route::get('/success', function () {
    return view('success');
})->name('success');

Route::get('/send-mail', [Mailcontroller::class, 'store']);

// Updated root route to use MailController
Route::get('/', [Mailcontroller::class, 'index']);

// If you want to keep the original closure-based route, comment the line above and uncomment the one below:
// Route::get('/', function () {
//     return view('welcome');
// });
