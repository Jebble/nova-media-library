<?php

namespace ClassicO\NovaMediaLibrary;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use ClassicO\NovaMediaLibrary\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-media-library');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/nova-media-library'));
	$this->loadMigrationsFrom(__DIR__.'/../database/migrations');

	    $this->publishes([
		    __DIR__.'/../config/' => config_path(),
		    __DIR__.'/../resources/lang' => resource_path('lang/vendor/nova-media-library'),
	    ], 'config-nml');

        $this->app->booted(function () {
            $this->routes();
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/nova-media-library')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
