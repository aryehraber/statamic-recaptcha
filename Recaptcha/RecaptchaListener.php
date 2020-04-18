<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Data\Users\User;
use Statamic\Extend\Listener;
use Statamic\Contracts\Forms\Submission;

class RecaptchaListener extends Listener
{
    public $events = [
        'Form.submission.creating' => 'beforeCreate',
        'user.registering' => 'beforeCreate',
    ];

    protected $captcha;

    public function __construct(Captcha $captcha)
    {
        $this->captcha = $captcha;
    }

    public function beforeCreate($data)
    {
        if (! $this->shouldVerify($data)) {
            return $data;
        }

        if ($this->captcha->verify()->invalidResponse()) {
            $dataType = $this->getDataType($data);
            $errors = ['captcha' => $this->getConfig('error_message')];

            return [$dataType => $data, 'errors' => $errors];
        }

        return $user;
    }

    protected function shouldVerify($data)
    {
        if ($data instanceof Submission) {
            return in_array($submission->formset()->name(), $this->getConfig('forms', []));
        }

        if ($data instanceof User) {
            return $this->getConfigBool('user_registration');
        }

        return false;
    }

    protected function getDataType($data)
    {
        if ($data instanceof Submission) {
            return 'submission';
        }

        if ($data instanceof User) {
            return 'user';
        }

        return 'data';
    }
}
