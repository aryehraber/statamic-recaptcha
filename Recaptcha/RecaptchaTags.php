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
        $attr = $this->get('invisible', false) ? 'data-size="invisible"' : '';

        return '<div class="g-recaptcha" data-sitekey="' . $this->getSiteKey() . '" ' . $attr . '></div>';
    }

    /**
     * The {{ recaptcha:head }} tag
     *
     * @return string
     */
    public function head()
    {
        if ($this->get('invisible', false)) {
            $data = ['hide_badge' => $this->get('hide_badge', false)];

            return $this->view('invisible', $data)->render();
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

    /**
     * Get the current domain's site key
     *
     * @return string
     */
    private function getSiteKey()
    {
        return (new Recaptcha)->config('site_key') ?: env('RECAPTCHA_SITE_KEY', '');
    }
}
