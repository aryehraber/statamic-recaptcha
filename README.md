# Recaptcha (Statamic V2)

**Protect your Statamic forms using reCAPTCHA or hCaptcha.**

This addon allows you to protect your Statamic forms from spam and abuse using [reCAPTCHA](https://www.google.com/recaptcha/intro/index.html) or [hCaptcha](https://hcaptcha.com/?r=eaeeea7cd23c) service.

After the initial setup, all you need to do is add the `{{ recaptcha }}` tag inside your forms, easy peasy!

<img src="https://www.google.com/recaptcha/intro/images/hero-recaptcha-demo.gif" alt="reCAPTCHA" width="350">

**For Statamic V3, please use the new Captcha addon: https://github.com/aryehraber/statamic-captcha**

## Setup

1. Firstly, copy the `Recaptcha` folder into `site/addons/`.

2. Next, you'll have to add reCAPTCHA's API script to your site's `<head>` using `{{ recaptcha:head }}`. You may also want to look into Statamic's [Yield](https://docs.statamic.com/tags/yield) & [Section](https://docs.statamic.com/tags/section) tags to only render the script when needed.

3. Then configure which forms will be using Recaptcha via the settings in the CP `(Configure > Addons > Recaptcha)`. Here you can also customise the error message shown when validation fails, as well as various other settings.

4. Finally, head over to https://www.google.com/recaptcha/admin, or https://dashboard.hcaptcha.com to create your `SITE_KEY` & `SECRET` and add them to Recaptcha's settings. Alternatively, add them to the site's `.env` file using `RECAPTCHA_SITE_KEY` & `RECAPTCHA_SECRET`. Please note: Recaptcha's Addon settings will take precedence over the `.env` settings.

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

This will automatically render the reCAPTCHA element on the page (if a valid `SITE_KEY` was found). After the form is submitted, the Addon will temporarily halt the form from saving while the submission is verified. If all is good, the form will save as normal, otherwise an error will be added to the `{{ errors }}` array (together with any other errors, if they exist) which you can handle the same way as you would normally.

## hCaptcha

As of v2.7.0, this Addon also supports [hCaptcha](https://hcaptcha.com/?r=eaeeea7cd23c)! Simply switch the Captcha Service setting to `hCaptcha` inside of `Configure > Addons > Recaptcha` and update the API keys to your hCaptcha keys.

## User Registration

As of v2.8.0, Recaptcha can verify user registration submissions from Statamic's `{{ user:register_form }}` form. Activate the feature inside `Configure > Addons > Recaptcha` and follow the same usage instructions as above.

## Invisible Recaptcha

As of v2.0, Recaptcha also supports the [Invisible reCAPTCHA](https://developers.google.com/recaptcha/docs/invisible):

1. Simply turn on the `Invisible` toggle in Recaptcha's settings.
2. Turn on `Hide Badge` to hide Recaptcha badge
3. Add required Google Terms and Privacy Policy using `{{ recaptcha:disclaimer }}`
