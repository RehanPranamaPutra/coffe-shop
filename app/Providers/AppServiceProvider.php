<?php

namespace App\Providers;

use App\Models\GajiKaryawan;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('currency', function ($expression) {
            return "Rp. <?php echo number_format($expression,0,',','.'); ?>";
        });

        Gate::define('roleOwner', function ($user) {
            return $user->role === 'Owner';
        });

        if ($this->app->environment('production') || env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
