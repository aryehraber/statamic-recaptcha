<?php

namespace Statamic\Addons\Recaptcha;

use GuzzleHttp\Client;
use Statamic\Extend\Listener;
use Statamic\Contracts\Forms\Submission;

class RecaptchaListener extends Listener
{
    /**
     * The events to be listened for, and the methods to call.
     *
     * @var array
     */
    public $events = [
        'Form.submission.creating' => 'beforeCreate'
    ];

    public function beforeCreate(Submission $submission)
    {
        if (! in_array($submission->formset()->name(), $this->getConfig('forms', []))) {
            return $submission;
        }

        $client = new Client();

        $params = [
            'secret' => $this->getSecret(),
            'response' => request('g-recaptcha-response'),
        ];

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', ['query' => $params]);

        if ($response->getStatusCode() == 200) {
            $data = collect(json_decode($response->getBody(), true));
        } else {
            throw new \Exception($response->getReasonPhrase());
        }

        if (! $data->get('success')) {
            return [
                'submission' => $submission,
                'errors' => [$this->getConfig('error_message') ?: 'reCAPTCHA failed.']
            ];
        }

        return $submission;
    }

    /**
     * Get the current domain's secret
     *
     * @return string
     */
    private function getSecret()
    {
        return (new Recaptcha)->config('secret') ?: env('RECAPTCHA_SECRET', '');
    }
}
