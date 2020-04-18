<?php

namespace Statamic\Addons\Recaptcha;

use GuzzleHttp\Client;
use Statamic\Extend\Extensible;

abstract class Captcha
{
    use Extensible;

    protected $client;

    protected $data;

    public function __construct()
    {
        $this->client = new Client(['http_errors' => false]);
    }

    abstract public function getResponseToken();

    abstract public function getVerificationUrl();

    abstract public function renderIndexTag($tag);

    abstract public function renderHeadTag($tag);

    public function config($field)
    {
        if (! $this->getConfigBool('multi_keys')) {
            return $this->getConfig($field);
        }

        $config = collect($this->getConfig('site_keys'))->first(function ($key, $config) {
            $domains = explode("\n", array_get($config, 'domains', ''));

            return in_array($this->currentDomain(), $domains);
        });

        return array_get($config, $field);
    }

    public function verify()
    {
        $query = [
            'secret' => $this->getSecret(),
            'response' => $this->getResponseToken(),
            'remoteip' => request()->ip(),
        ];

        $response = $this->client->post($this->getVerificationUrl(), compact('query'));

        if ($response->getStatusCode() == 200) {
            $this->data = collect(json_decode($response->getBody(), true));
        }

        return $this;
    }

    /**
     * Check whether the response was valid
     *
     * @return bool
     */
    public function validResponse()
    {
        if (is_null($this->data)) {
            return false;
        }

        if (! $this->data->get('success')) {
            return false;
        }

        return true;
    }

    /**
     * Check whether the response was invalid
     *
     * @return bool
     */
    public function invalidResponse()
    {
        return ! $this->validResponse();
    }

    /**
     * Get the configured Captcha Site Key
     *
     * @return string
     */
    public function getSiteKey()
    {
        return $this->config('site_key') ?: env('RECAPTCHA_SITE_KEY', '');
    }

    /**
     * Get the configured Captcha Secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->config('secret') ?: env('RECAPTCHA_SECRET', '');
    }

    /**
     * Get the current domain, excluding 'http(s)://'
     *
     * @return string
     */
    protected function currentDomain()
    {
        return preg_split('/http(s)?:\/\//', url())[1];
    }
}
