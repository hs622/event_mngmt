<?php

use App\Http\Livewire\Events;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Users;
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

Route::get('/', function () { return view('welcome'); });
Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified' ])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/users', Users::class)->name('user');
    Route::get('/user/{user}', Users::class)->name('users');
    
    Route::get('/roles', Roles::class)->name('role');
    Route::get('/role/create', Roles::class)->name('role.create');
    
    Route::get('/events', Events::class)->name('event');

    // Route::get('/events', ShowPosts::class)->name('event');
    // Route::get('/event/{event}', ShowPosts::class)->name('event.show');
    // Route::get('/event/{event}/schedule', ShowPosts::class)->name('event.schedule');
});
