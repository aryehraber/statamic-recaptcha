<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\Tags;

class RecaptchaTags extends Tags
{
    protected $captcha;

    public function __construct(Captcha $captcha)
    {
        $this->captcha = $captcha;
    }

    /**
     * The {{ captcha }} tag
     *
     * @return string
     */
    public function index()
    {
        return $this->captcha->renderIndexTag($this);
    }

    /**
     * The {{ captcha:head }} tag
     *
     * @return string
     */
    public function head()
    {
        return $this->captcha->renderHeadTag($this);
    }

    /**
     * The {{ captcha:disclaimer }} tag
     *
     * @return string
     */
    public function disclaimer()
    {
        if (! $disclaimer = $this->get('disclaimer')) {
            $disclaimer = $this->captcha->getDefaultDisclaimer();
        }

        return markdown($disclaimer);
    }

    /**
     * Helper to build HTML element attributes string
     *
     * @return string
     */
    public function buildAttributes($attributes)
    {
        return collect($attributes)->filter()->map(function ($value, $key) {
            return sprintf('%s="%s"', $key, $value);
        })->implode(' ');
    }
}
