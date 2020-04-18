<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Captcha::class, function() {
            $service = $this->getConfig('captcha_service');
            $class = "Statamic\\Addons\\Recaptcha\\{$service}";

            if (! class_exists($class)) {
                throw new \Exception('Invalid Captcha service.');
            }

            return new $class;
        });
    }
}
