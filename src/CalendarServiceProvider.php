<?php

namespace Spork\Calendar;

use App\Spork;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CalendarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'calendar-migrations');

        Spork::addFeature('calendar', 'CalendarIcon', '/calendar', 'tool');

        Route::middleware($this->app->make('config')->get('spork.calendar.middleware', ['auth:sanctum']))
            ->prefix('api/calendar')
            ->group(__DIR__ . '/../routes/api.php');
    }
}