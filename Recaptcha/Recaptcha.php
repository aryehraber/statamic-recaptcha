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

    public function renderIndexTag($tag)
    {
        $attributes = $tag->buildAttributes([
            'data-sitekey' => $this->getSiteKey(),
            'data-size' => $tag->get('invisible') ? 'invisible' : '',
        ]);

        return "<div class=\"g-recaptcha\" {$attributes}></div>";
    }

    public function renderHeadTag($tag)
    {
         if ($tag->getBool('invisible')) {
            return $tag->view('invisible', ['hide_badge' => $tag->get('hide_badge')])->render();
        }

        return '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    }
}
