<?php

namespace MohsenFathipour\CaptchaGenerator;

use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind the CAPTCHA generator class
        $this->app->singleton(CaptchaGenerator::class, function ($app) {
            return new CaptchaGenerator();
        });
    }

    public function boot()
    {
        // Publish the configuration file to the app's config folder
        $this->publishes([
            __DIR__.'/../config/captcha.php' => config_path('captcha.php'),
        ], 'config');

        // Register routes for CAPTCHA
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
