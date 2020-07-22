<?php

namespace AryehRaber\Recaptcha\Listeners;

use GuzzleHttp\Client;
use Statamic\Forms\Submission;
use Statamic\Events\FormSubmitted;
use Illuminate\Validation\ValidationException;

class ValidateFormSubmission
{
    public function handle(FormSubmitted $event)
    {
        $submission = $event->form;

        if (! in_array($submission->form()->handle(), config('recaptcha.forms', []))) {
            return $submission;
        }

        $client = new Client();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', ['query' => [
            'secret' => config('recaptcha.secret'),
            'response' => request('g-recaptcha-response'),
        ]]);

        if ($response->getStatusCode() == 200) {
            $data = collect(json_decode($response->getBody(), true));
        } else {
            throw new \Exception($response->getReasonPhrase());
        }

        if (! $data->get('success')) {
            throw ValidationException::withMessages([
                'recaptcha' => config('recaptcha.error_message', 'reCAPTCHA failed.')
            ]);
        }

        return $submission;
    }
}
