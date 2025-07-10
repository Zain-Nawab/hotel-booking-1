<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [BlogController::class, 'index'])->name('home.index');
Route::get('/rooms', [BlogController::class, 'rooms'])->name('rooms.index');
Route::get('/blog/room/show/{id}', [BlogController::class, 'show'])->name('rooms.show');
Route::get('/blog', [BlogController::class, 'blog'])->name('home.blog');
Route::get('/blog/detail', [BlogController::class, 'detail'])->name('blog.detail');
Route::get('/blog/aboutus', [BlogController::class, 'aboutus'])->name('blog.aboutus');

Route::get('/email/verify/{user}', [AuthController::class, 'showEmailVerificationForm'])->name('email.verify.form');
Route::post('/email/verify/{user}', [AuthController::class, 'verifyEmail'])->name('email.verify');
Route::get('/email/resend/{user}', [AuthController::class, 'resendVerificationCode'])->name('email.resend');



// auth login/sign up

Route::get("/login", [AuthController::class, 'loginForm'])->name("loginForm");
Route::post("/login", [AuthController::class, 'login'])->name("login");
Route::get("/logout", [AuthController::class, 'logout'])->name('logout');
Route::get("/signup", [AuthController::class, 'signupForm'])->name("signupForm");
Route::post("/register", [AuthController::class, 'register'])->name("register");


//admin route
Route::middleware(['auth', 'is_admin'])->prefix('/admin')->group( function() {

    Route::get('/main', [DashboardController::class, 'index'])->name('admin.main');

    // addmin rooom routes 
    Route::get('/rooms', [AdminRoomController::class, 'index'])->name('room.index');
    Route::get('/room/create', [AdminRoomController::class, 'create'])->name('room.create');
    Route::post('room/store', [AdminRoomController::class, 'store'])->name('room.store');
    Route::get('/room/edit/{id}', [AdminRoomController::class, 'edit'])->name('room.edit');
    Route::post('/room/update/{id}', [AdminRoomController::class, 'update'])->name('room.update');
    Route::delete('/room/delete/{id}', [AdminRoomController::class, 'destroy'])->name('room.destroy');

    //customers index
    Route::get('/customers', [DashboardController::class, 'customers'])->name('customers.index');
    Route::get('/customer/show/{id}', [UserController::class, 'show'])->name('customer.show');
    Route::delete('/customer/delete/{id}', [UserController::class, 'deleteAccount'])->name('customer.delete');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');

    Route::get('bookings/export', [AdminBookingController::class, 'export'])->name('bookings.export');
});

// auth user 
Route::middleware('auth')->group(function () {

    //rooms routes
    Route::get('/room/{id}/booking', [BookingController::class, 'create'])->name('room.booking');
    Route::post('/room/{id}/book', [BookingController::class, 'store'])->name('room.book.store');
    Route::get('/room/{id}/check-availability', [BookingController::class, 'checkAvailability'])->name('room.check-availability');
    Route::get('/room/{id}/check-availability-json', [BookingController::class, 'checkAvailabilityJson'])->name('room.check-availability-json');

    //booking routes
    Route::patch('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/bookings/status-check', [BookingController::class, 'statusCheck'])->name('booking.status-check');

    //payment routes
    Route::get('/payment/process/{id}', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::post('/payment/refund', [PaymentController::class, 'refundPayment'])->name('payment.refund');
    Route::get('/payment/status', [PaymentController::class, 'getPaymentStatus'])->name('payment.status');
    Route::get('/payment/transactions', [PaymentController::class, 'listTransactions'])->name('payment.transactions');
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payments.success');
    Route::get('/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payments.cancel');

    //user dashboard
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/bookings/history', [UserController::class, 'bookingHistory'])->name('user.bookings.history');

});

//Github OAuth
Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('auth.github.redirect');

Route::get('/auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    // Find or create user
    $user = User::updateOrCreate([
        'email' => $githubUser->email,
    ], [
        'name' => $githubUser->name ?? $githubUser->nickname,
        'github_id' => $githubUser->id,
        'github_token' => $githubUser->token,
        'github_refresh_token' => $githubUser->refreshToken,
        'password' => bcrypt(str()->random(16)), // Random password
    ]);

    // Login the user
    auth()->login($user);

    return redirect()->intended('/');
});