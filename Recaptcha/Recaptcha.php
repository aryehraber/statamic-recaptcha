<?php

namespace Statamic\Addons\Recaptcha;

class Recaptcha extends Captcha
{
    public function getResponseToken()
    {
        return request('g-recaptcha-response');
    }

    public function getVerificationUrl()
    {
        return 'https://www.google.com/recaptcha/api/siteverify';
    }

    public function getDefaultDisclaimer()
    {
        return 'This site is protected by reCAPTCHA and the Google [Privacy Policy](https://policies.google.com/privacy) and [Terms of Service](https://policies.google.com/terms) apply.';
    }

    public function renderIndexTag($tag)
    {
        $attributes = $tag->buildAttributes([
            'data-sitekey' => $this->getSiteKey(),
            'data-size' => $tag->getBool('invisible') ? 'invisible' : '',
        ]);

        return "<div class=\"g-recaptcha\" {$attributes}></div>";
    }

    public function renderHeadTag($tag)
    {
        $url = 'https://www.google.com/recaptcha/api.js';

        if ($lang = $tag->get('language_code')) {
            $url .= "?hl={$lang}";
        }

        return $tag->view('recaptcha.head', [
            'invisible' => $tag->getBool('invisible'),
            'hide_badge' => $tag->getBool('hide_badge'),
            'url' => $url,
        ])->render();
    }
}
