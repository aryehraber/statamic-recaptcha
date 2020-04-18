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

    public function renderIndexTag($tag)
    {
        $attributes = $tag->buildAttributes([
            'data-sitekey' => $this->getSiteKey(),
        ]);

        return "<div class=\"h-captcha\" {$attributes}></div>";
    }

    public function renderHeadTag($tag)
    {
        return '<script src="https://hcaptcha.com/1/api.js" async defer></script>';
    }
}
