<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;

;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [BlogController::class, 'index'])->name('home.index');


// auth login/sign up

Route::get("/login", [AuthController::class, 'loginForm'])->name("loginForm");
Route::post("/login", [AuthController::class, 'login'])->name("login");
Route::post("/logout", [AuthController::class, 'logout'])->name('logout');
Route::get("/signup", [AuthController::class, 'signupForm'])->name("signupForm");
Route::post("/register", [AuthController::class, 'register'])->name("register");


//admin route
Route::get('/admin/main', [DashboardController::class, 'index'])->name('admin.main');

Route::get('/admin/rooms', [AdminRoomController::class, 'index'])->name('room.index');
Route::get('/admin/room/create', [AdminRoomController::class, 'create'])->name('room.create');
Route::post('/admin/room/store', [AdminRoomController::class, 'store'])->name('room.store');

Route::get('/admin/room/edit/{id}', [AdminRoomController::class, 'edit'])->name('room.edit');
Route::get('/admin/room/update/{id}', [AdminRoomController::class, 'update'])->name('room.update');
Route::get('/admin/room/delete/{id}', [AdminRoomController::class, 'destroy'])->name('room.destroy');

Route::get('/admin/room/show/{id}', [AdminRoomController::class, 'show'])->name('room.show');
Route::get('/admin/room/bookings/{id}', [AdminRoomController::class, 'bookings'])->name('room.bookings');