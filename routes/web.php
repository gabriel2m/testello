<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')
    ->name('profile.')
    ->group(function () {
        Route::get('profile', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('destroy');
    });

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('customers/{customer}/deliveries/create', [DeliveryController::class, 'bulkCreate'])->name('deliveries.bulk-create');
        Route::post('customers/{customer}/deliveries', [DeliveryController::class, 'bulkStore'])->name('deliveries.bulk-store');
        Route::delete('customers/{customer}/deliveries', [DeliveryController::class, 'bulkDestroy'])->name('deliveries.bulk-destroy');
        Route::resource('customers', CustomerController::class);
    });

require __DIR__ . '/auth.php';
