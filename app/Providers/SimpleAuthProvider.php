<?php
/**
 * https://gist.github.com/jcodt/f9ee49051b75df4d00bd
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SimpleAuthProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->extend('simple',function($app)
        {
            return new SimpleUserProvider($app['config']['auth.credentials']);
        });
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}