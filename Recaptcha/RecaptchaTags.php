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
        if (! $this->get('invisible', false)) {
            return '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        } else {
            return '
                <script>
                    var recaptchaCallback = function (form) {
                        return function () {
                            form.submit();
                        }
                    };

                    document.addEventListener("DOMContentLoaded", function () {
                        var captchas = Array.prototype.slice.call(document.querySelectorAll(".g-recaptcha[data-size=invisible]"), 0);

                        var formId = 0;
                        captchas.forEach(function (captcha) {
                            ++formId;
                            var form = captcha.parentNode;
                            while (form.tagName !== "FORM") {
                                form = form.parentNode;
                            }

                            // create custom callback
                            window["recaptchaSubmit" + formId] = recaptchaCallback(form);
                            captcha.setAttribute("data-callback", "recaptchaSubmit" + formId);

                            form.addEventListener("submit", function (event) {
                                event.preventDefault();
                                grecaptcha.reset();
                                grecaptcha.execute();
                            });
                        });
                    });
                </script>
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            ';
        }
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
