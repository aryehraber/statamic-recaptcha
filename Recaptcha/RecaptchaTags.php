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
        return markdown($this->get('disclaimer'));
    }

    public function buildAttributes($attributes)
    {
        return collect($attributes)->filter()->map(function ($value, $key) {
            return sprintf('%s="%s"', $key, $value);
        })->implode(' ');
    }
}
