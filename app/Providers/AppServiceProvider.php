<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Appointment::saved(function ($appointment) {
            if (!$appointment->wasRecentlyCreated && $appointment->wasChanged('status')) {
                \App\Services\ClinicNotifications::publish(
                    'dental-appointment:' . $appointment->id . ':' . $appointment->status . ':' . $appointment->updated_at,
                    $appointment->campus,
                    ['Dentist', 'Attendant'],
                    'Dental appointment updated to ' . $appointment->status . '.',
                    '/view-appointment'
                );
            }
        });
    }
}
