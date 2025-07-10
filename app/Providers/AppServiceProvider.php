<?php

namespace App\Providers;

use App\Jobs\AutoCancelUnpaidBookings;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected function schedule(Schedule $schedule)
   {
        // Run every 15 minutes to check for unpaid bookings
        $schedule->job(new AutoCancelUnpaidBookings)
                ->everyFifteenMinutes()
                ->withoutOverlapping();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
