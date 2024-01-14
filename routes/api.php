<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [Mailcontroller::class, 'store'])->name('register');

Route::get('/success', function () {
    return view('success');
})->name('success');

Route::get('/send-mail', [Mailcontroller::class, 'store']);

// Updated root route to use MailController
Route::get('/', [Mailcontroller::class, 'index']);
