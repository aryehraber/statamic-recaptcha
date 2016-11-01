<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\Tags;

class RecaptchaTags extends Tags
{
    /**
     * The {{ recaptcha }} tag
     *
     * @return string
     */
    public function index()
    {
        $siteKey = $this->getConfig('site_key') ?: env('RECAPTCHA_SITE_KEY', '');

        return '<div class="g-recaptcha" data-sitekey="'. $siteKey .'"></div>';
    }
    /**
     * The {{ recaptcha:head }} tag
     *
     * @return string
     */
    public function head()
    {
        return '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    }
}
