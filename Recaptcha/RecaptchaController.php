<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\Controller;

class RecaptchaController extends Controller
{
    protected $recaptcha;

    public function __construct(Recaptcha $recaptcha)
    {
        $this->recaptcha = $recaptcha;
    }

    /**
     * Get the current domain's site key
     *
     * @return string
     */
    public function getSiteKey()
    {
        return $this->recaptcha->getSiteKey();
    }
}
