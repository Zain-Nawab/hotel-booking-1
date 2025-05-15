<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Admin\DashboardController;


// Public
Route::get('/', [RoomController::class, 'index'])->name('room.index');


Route::get('/admin/main', [DashboardController::class, 'index'])->name('admin.index');