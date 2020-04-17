<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\Listener;
use Statamic\Contracts\Forms\Submission;

class RecaptchaListener extends Listener
{
    public $events = [
        'Form.submission.creating' => 'beforeCreate'
    ];

    protected $recaptcha;

    public function __construct(Recaptcha $recaptcha)
    {
        $this->recaptcha = $recaptcha;
    }

    public function beforeCreate(Submission $submission)
    {
        if (! $this->shouldVerifySubmission($submission)) {
            return $submission;
        }

        if ($this->recaptcha->verify()->invalidResponse()) {
            $errors = ['recaptcha' => $this->getConfig('error_message')];

            return compact('submission', 'errors');
        }

        return $submission;
    }

    protected function shouldVerifySubmission($submission)
    {
        return in_array($submission->formset()->name(), $this->getConfig('forms', []));
    }
}
