<?php

namespace Minhyung\Fss;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Minhyung\Fss\FinLife\FinLife;
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

        $this->app->bind(Lifespan::class, fn (Application $app) => new Lifespan($app->make('config')->get('fss.lifespan')));
        $this->app->alias(Lifespan::class, 'fss.lifespan');

        $this->app->bind(FinLife::class, fn (Application $app) => new FinLife($app->make('config')->get('fss.finlife')));
        $this->app->alias(FinLife::class, 'fss.finlife');
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
