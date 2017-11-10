<?php

namespace Statamic\Addons\Recaptcha;

use Statamic\Extend\Extensible;

class Recaptcha
{
    use Extensible;

    public function config($field)
    {
        if ($multiKeys = $this->getConfigBool('multi_keys')) {
            $config = collect($this->getConfig('site_keys'))
                ->first(function ($key, $config) {
                    $domains = explode("\n", array_get($config, 'domains', ''));

                    return in_array($this->currentDomain(), $domains);
                });
        }

        return $multiKeys ? array_get($config, $field) : $this->getConfig($field);
    }

    /**
     * Get the current domain, excluding 'http(s)://'
     *
     * @return string
     */
    private function currentDomain()
    {
        return preg_split('/http(s)?:\/\//', url())[1];
    }
}
