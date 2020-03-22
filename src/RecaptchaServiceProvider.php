<?php

namespace AryehRaber\Recaptcha;

use Illuminate\Support\Facades\Route;
use AryehRaber\Recaptcha\Tags\Recaptcha;
use Statamic\Providers\AddonServiceProvider;
use AryehRaber\Recaptcha\Listeners\ValidateFormSubmission;

class RecaptchaServiceProvider extends AddonServiceProvider
{
    protected $tags = [
       Recaptcha::class,
    ];

    protected $listen = [
        'Form.submission.creating' => [
            ValidateFormSubmission::class,
        ],
    ];

    public function boot()
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'recaptcha');

        $this->mergeConfigFrom(__DIR__.'/../config/recaptcha.php', 'recaptcha');

        $this->publishes([
            __DIR__.'/../config/recaptcha.php' => config_path('recaptcha.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/recaptcha'),
        ], 'views');

        if (config('recaptcha.enable_api_routes')) {
            $this->registerWebRoutes(function () {
                Route::get(config('statamic.routes.action').'/recaptcha/sitekey', function () {
                    return response()->json(['sitekey' => config('recaptcha.sitekey')]);
                });
            });
        }
    }
}
