<?php

namespace Minhyung\Fss;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Minhyung\Fss\Lifespan\Lifespan;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/fss.php', 'fss');

        $this->app->bind(Lifespan::class, fn (Application $app) => new Lifespan($app->make('config')->get('fss')));
        $this->app->alias(Lifespan::class, 'fss.lifespan');
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fss.php' => config_path('fss.php'),
            ], 'fss');
        }
    }
}
