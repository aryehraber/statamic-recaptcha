<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\Listener;
use Statamic\Contracts\Forms\Submission;

class RecaptchaListener extends Listener
{
    public $events = [
        'Form.submission.creating' => 'beforeCreate'
    ];

    protected $captcha;

    public function __construct(Captcha $captcha)
    {
        $this->captcha = $captcha;
    }

    public function beforeCreate(Submission $submission)
    {
        if (! $this->shouldVerifySubmission($submission)) {
            return $submission;
        }

        if ($this->captcha->verify()->invalidResponse()) {
            $errors = ['captcha' => $this->getConfig('error_message')];

            return compact('submission', 'errors');
        }

        return $submission;
    }

    protected function shouldVerifySubmission($submission)
    {
        return in_array($submission->formset()->name(), $this->getConfig('forms', []));
    }
}
