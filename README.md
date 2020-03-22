# Recaptcha (Statamic 3)

**Protect your Statamic forms using Google's reCAPTCHA service.**

This addon allows you to protect your Statamic forms from spam and abuse using [Google's reCAPTCHA service](https://www.google.com/recaptcha/intro/index.html).

After the initial setup, all you need to do is add the `{{ recaptcha }}` tag inside your forms, easy peasy! See further details below...

<img src="https://www.google.com/recaptcha/intro/images/hero-recaptcha-demo.gif" alt="reCAPTCHA" width="350">

## Installation

Install the addon via composer:

```
composer require aryehraber/statamic-recaptcha:dev-statamic-3
```

Publish the config file:

```
php artisan vendor:publish --provider="AryehRaber\Recaptcha\RecaptchaServiceProvider" --tag="config"
```

Alternately, you can manually setup the config file by creating `recaptcha.php` inside your project's `config` directory:

```php
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
```

Once the config file is in place, make sure to add your `sitekey` & `secret` from [Recaptcha's Console](https://www.google.com/recaptcha/admin) and add the  handles of the Statamic Forms you'd like to protect:

```php
<?php

return [
    'sitekey' => env('RECAPTCHA_SITEKEY', 'YOUR_SITEKEY_HERE'), // Or add to .env
    'secret' => env('RECAPTCHA_SECRET', 'YOUR_SECRET_HERE'), // Or add to .env
    'forms' => ['contact', 'newsletter'],
    // ...
];
```

## Usage

```html
<head>
    <title>My Awesome Site</title>

    {{ recaptcha:head }}
</head>
<body>
    {{ form:create in="my-awesome-form" }}

        <!-- Add your fields like normal -->

        {{ recaptcha }}

    {{ /form:create }}
</body>
```

This will automatically render the reCAPTCHA element on the page (assuming a valid `sitekey` & `secret` were found). After the form is submitted, the addon will temporarily halt the form from saving while Google verifies that the request checks out. If all is good, the form will save as normal, otherwise an error will be added to the `{{ errors }}` array (together with any other errors, if they exist) which you can handle the same way as you would normally.

## Invisible Recaptcha

Simply set `invisible` to `true` inside Recaptcha's config.

### Hide Recaptcha Badge

To hide the sticky Recaptcha badge, set `hide_badge` to `true` inside Recaptcha's config. Doing so will require you to display links to Google's Terms yourself, to make this easier use `{{ recaptcha:disclaimer }}` -- this can be customised using the `disclaimer` option inside Recaptcha's config.
