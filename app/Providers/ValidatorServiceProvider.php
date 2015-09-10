<?php

namespace PlayableStories\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('hex', function ($attribute, $value, $parameters) {
            if (preg_match("/^#?([a-f0-9]{6}|[a-f0-9]{3})$/", $value)) {
                return true;
            }
            return false;
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
