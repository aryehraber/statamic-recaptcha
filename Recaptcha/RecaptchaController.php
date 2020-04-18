<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\Controller;

class RecaptchaController extends Controller
{
    protected $captcha;

    public function __construct(Captcha $captcha)
    {
        $this->captcha = $captcha;
    }

    /**
     * Get the current domain's site key
     *
     * @return string
     */
    public function getSiteKey()
    {
        return $this->captcha->getSiteKey();
    }
}
