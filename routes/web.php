<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\TimeLogController;
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

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('stock-movements', StockMovementController::class);

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [InventoryController::class, 'dashboard'])->name('dashboard');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    Route::get('/clock-in-out', [TimeLogController::class, 'clockInOut'])->name('clock-in-out');
    Route::post('/clock-in', [TimeLogController::class, 'clockIn'])->name('clock-in');
    Route::post('/break-in', [TimeLogController::class, 'breakIn'])->name('break-in');
    Route::post('/break-out', [TimeLogController::class, 'breakOut'])->name('break-out');
    Route::post('/clock-out', [TimeLogController::class, 'clockOut'])->name('clock-out');


    Route::get('/tracking', [AuditController::class, 'index'])->name('tracking.index');
    Route::get('/tracking/create', [AuditController::class, 'create'])->name('tracking.create');
    Route::post('/tracking', [AuditController::class, 'store'])->name('tracking.store');
    Route::get('/tracking/{id}', [AuditController::class, 'show'])->name('tracking.show');
    Route::get('/tracking/{id}/edit', [AuditController::class, 'edit'])->name('tracking.edit');
    Route::put('/tracking/{id}', [AuditController::class, 'update'])->name('tracking.update');
    Route::delete('/tracking/{id}', [AuditController::class, 'destroy'])->name('tracking.destroy');
});

//Auth
Route::get('/register', [RegisterUserController::class, 'create']);
Route::post('/register', [RegisterUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);