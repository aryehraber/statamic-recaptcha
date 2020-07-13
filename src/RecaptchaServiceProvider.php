<?php

namespace AryehRaber\Recaptcha;

use Illuminate\Support\Facades\Route;
use Statamic\Events\Data\FormSubmitted;
use AryehRaber\Recaptcha\Tags\Recaptcha;
use Statamic\Providers\AddonServiceProvider;
use AryehRaber\Recaptcha\Listeners\ValidateFormSubmission;

class RecaptchaServiceProvider extends AddonServiceProvider
{
    protected $tags = [
       Recaptcha::class,
    ];

    protected $listen = [
        FormSubmitted::class => [
            ValidateFormSubmission::class,
        ],
    ];

    protected $routes = [
        'web' => __DIR__.'/../routes/web.php',
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
    }
}
