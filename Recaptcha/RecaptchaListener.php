<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Data\Users\User;
use Statamic\Extend\Listener;
use Statamic\Contracts\Forms\Submission;

class RecaptchaListener extends Listener
{
    public $events = [
        'Form.submission.creating' => 'handle',
        'user.registering' => 'handle',
    ];

    protected $captcha;

    public function __construct(Captcha $captcha)
    {
        $this->captcha = $captcha;
    }

    public function handle($data)
    {
        if (! $this->shouldVerify($data)) {
            return $data;
        }

        if ($this->captcha->verify()->invalidResponse()) {
            $errors = ['captcha' => $this->getConfig('error_message')];

            return ['errors' => $errors];
        }

        return $data;
    }

    protected function shouldVerify($data)
    {
        if ($data instanceof Submission) {
            return in_array($data->formset()->name(), $this->getConfig('forms', []));
        }

        if ($data instanceof User) {
            return $this->getConfigBool('user_registration');
        }

        return false;
    }
}
