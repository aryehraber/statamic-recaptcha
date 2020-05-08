<?php

namespace Statamic\Addons\Recaptcha;

class Hcaptcha extends Captcha
{
    public function getResponseToken()
    {
        return request('h-captcha-response');
    }

    public function getVerificationUrl()
    {
        return 'https://hcaptcha.com/siteverify';
    }

    public function getDefaultDisclaimer()
    {
        return 'This site is protected by hCaptcha and its <a href="https://hcaptcha.com/privacy">Privacy Policy</a> and <a href="https://hcaptcha.com/terms">Terms of Service</a> apply.';
    }

    public function renderIndexTag($tag)
    {
        $attributes = $tag->buildAttributes([
            'data-sitekey' => $this->getSiteKey(),
            'data-size' => $tag->getBool('invisible') ? 'invisible' : '',
        ]);

        return "<div class=\"h-captcha\" {$attributes}></div>";
    }

    public function renderHeadTag($tag)
    {
        $url = 'https://hcaptcha.com/1/api.js';

        return $tag->view('hcaptcha.head', [
            'invisible' => $tag->getBool('invisible'),
            'url' => $url,
        ])->render();
    }
}
