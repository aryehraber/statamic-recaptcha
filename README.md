# Recaptcha

**Protect your Statamic forms using Google's reCAPTCHA service.**

This addon allows you to protect your Statamic forms from spam and abuse using [Google's reCAPTCHA service](https://www.google.com/recaptcha/intro/index.html).

After the initial setup, all you need to do is add the `{{ recaptcha }}` tag inside your forms, easy peasy! See further details below...

![reCAPTCHA](https://www.google.com/recaptcha/intro/images/hero-recaptcha-demo.gif)

## Setup

1. Firstly, copy the `Recaptcha` folder into `site/addons/`.

2. Next, you'll have to add reCAPTCHA's API script to your site's `<head>` using `{{ recaptcha:head }}`. You may also want to look into Statamic's [Yield](https://docs.statamic.com/tags/yield) & [Section](https://docs.statamic.com/tags/section) tags to only render the script when needed.

3. Then configure which forms will be using Recaptcha via the settings in the CP `(Configure > Addons > Recaptcha)`. Here you can also customise the error message shown when validation fails.

4. Finally, head over to https://www.google.com/recaptcha/admin to create your `SITE_KEY` & `SECRET` and add them to Recaptcha's settings. Alternatively, add them to the site's `.env` file using `RECAPTCHA_SITE_KEY` & `RECAPTCHA_SECRET`. Please note: Recaptcha's Addon settings will take precedence over the `.env` settings.

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

This will automatically render the reCAPTCHA element on the page (if a valid `SITE_KEY` was found). After the form is submitted, the Addon will temporarily halt the form from saving while Google verifies that the request checks out. If all is good, the form will save as normal, otherwise an error will be added to the `{{ errors }}` array (together with any other errors, if they exist) which you can handle the same way as you would normally.

Invisible Recaptcha: button class="recaptcha-btn" 