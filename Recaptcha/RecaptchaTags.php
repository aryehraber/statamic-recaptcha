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
        if ($this->get('invisible', false)) {
            return;
        }

        $siteKey = $this->getSiteKey();
        return '<div class="g-recaptcha" data-sitekey="'. $siteKey .'"></div>';
    }

    /**
     * The {{ recaptcha:head }} tag
     *
     * @return string
     */
    public function head()
    {
        if (!$this->get('invisible', false)) {
            return '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        } else {
            $siteKey = $this->getSiteKey();

            // invisible recaptcha loading code
            return'
                <script>
                    function recaptchaInit() {
                        var buttons = Array.prototype.slice.call(document.querySelectorAll(".recaptcha-btn"), 0);

                        buttons.forEach(function (button) {
                            var form = button.form;

                            if (!("checkValidity" in form) || form.checkValidity()) {
                                grecaptcha.render(button, {
                                    sitekey : "'.$siteKey.'",
                                    callback : function () {
                                        form.submit();
                                    }
                                });
                            }
                        });
                    }
                </script>
                <script src="https://www.google.com/recaptcha/api.js?onload=recaptchaInit&render=explicit" async defer></script>
            ';
        }
    }

    /**
     * @return string
     */
    private function getSiteKey() {
        return $this->getConfig('site_key') ?: env('RECAPTCHA_SITE_KEY', '');
    }
}
