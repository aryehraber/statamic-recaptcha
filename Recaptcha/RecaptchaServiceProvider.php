<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Recaptcha::class);
    }
}
