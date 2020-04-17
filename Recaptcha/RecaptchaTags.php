<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\Tags;

class RecaptchaTags extends Tags
{
    protected $recaptcha;

    public function __construct(Recaptcha $recaptcha)
    {
        $this->recaptcha = $recaptcha;
    }

    /**
     * The {{ recaptcha }} tag
     *
     * @return string
     */
    public function index()
    {
        $attr = $this->get('invisible', false) ? 'data-size="invisible"' : '';

        return '<div class="g-recaptcha" data-sitekey="' . $this->recaptcha->getSiteKey() . '" ' . $attr . '></div>';
    }

    /**
     * The {{ recaptcha:head }} tag
     *
     * @return string
     */
    public function head()
    {
        if ($this->get('invisible', false)) {
            return $this->view('invisible', [
                'hide_badge' => $this->get('hide_badge', false),
            ])->render();
        }

        return '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    }

    /**
     * The {{ recaptcha:disclaimer }} tag
     *
     * @return string
     */
    public function disclaimer()
    {
        return markdown($this->get('disclaimer'));
    }
}
