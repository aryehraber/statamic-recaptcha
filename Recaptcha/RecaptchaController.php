<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\Controller;

class RecaptchaController extends Controller
{
    /**
     * Get the current domain's site key
     *
     * @return string
     */
    public function getSiteKey()
    {
        return (new Recaptcha)->config('site_key') ?: env('RECAPTCHA_SITE_KEY', '');
    }
}
