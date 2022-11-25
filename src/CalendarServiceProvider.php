<?php

namespace Spork\Calendar;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spork\Calendar\Models\RepeatEvent;
use Spork\Core\Models\FeatureList;
use Spork\Core\Spork;

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
        FeatureList::extend('repeatable', function () {
            return $this->morphMany(RepeatEvent::class, 'repeatable');
        });
        Spork::addFeature('calendar', 'CalendarIcon', '/calendar', 'tool');

        Spork::loadWith(['repeatable.users.user']);
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->mergeConfigFrom(__DIR__.'/../config/spork.php', 'spork.calendar');
        Route::middleware($this->app->make('config')->get('spork.calendar.middleware', ['auth:sanctum']))
            ->prefix('api/calendar')
            ->group(__DIR__.'/../routes/api.php');
    }
}
