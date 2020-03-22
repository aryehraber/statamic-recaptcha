<?php

return [
    'sitekey' => env('RECAPTCHA_SITEKEY', ''),
    'secret' => env('RECAPTCHA_SECRET', ''),
    'forms' => [],
    'invisible' => false,
    'hide_badge' => false,
    'enable_api_routes' => false,
    'error_message' => 'reCAPTCHA failed.',
    'disclaimer' => 'This site is protected by reCAPTCHA and the Google [Privacy Policy](https://policies.google.com/privacy) and [Terms of Service](https://policies.google.com/terms) apply.',
];
