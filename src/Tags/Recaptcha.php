<?php

namespace AryehRaber\Recaptcha\Tags;

use Statamic\Tags\Tags;
use Statamic\Support\Html;

class Recaptcha extends Tags
{
    /**
     * The {{ recaptcha }} tag
     *
     * @return string
     */
    public function index()
    {
        $attr = config('recaptcha.invisible') ? 'data-size="invisible"' : '';

        return '<div class="g-recaptcha" data-sitekey="' . config('recaptcha.sitekey') . '" ' . $attr . '></div>';
    }

    /**
     * The {{ recaptcha:head }} tag
     *
     * @return string
     */
    public function head()
    {
        if (config('recaptcha.invisible')) {
            $data = ['hide_badge' => config('recaptcha.hide_badge')];

            return view('recaptcha::invisible', $data)->render();
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
        return Html::markdown(config('recaptcha.disclaimer', ''));
    }
}
