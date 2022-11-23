<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\TicketController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('tickets', TicketController::class)
    ->only(['index', 'create', 'store', 'show', 'update'])
    ->middleware(['auth', 'verified']);

Route::get('open-tickets', [TicketController::class, 'index_open'])
    ->name('tickets.index_open');

Route::get('closed-tickets', [TicketController::class, 'index_closed'])
    ->name('tickets.index_closed');

Route::resource('comments', CommentController::class)
    ->only(['store'])
    ->middleware(['auth', 'verified']);

Route::get('open-service-requests', [ServiceRequestController::class, 'index_open'])
    ->name('service_requests.index_open');

Route::get('closed-service-requests', [ServiceRequestController::class, 'index_closed'])
    ->name('service_requests.index_closed');

Route::resource('service_requests', ServiceRequestController::class)
    ->only(['index', 'store', 'show', 'edit', 'update'])
    ->middleware(['auth', 'verified']);

Route::resource('admin', AdminController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
