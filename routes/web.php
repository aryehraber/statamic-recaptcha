<?php

use Illuminate\Support\Facades\Route;

if (config('recaptcha.enable_api_routes')) {
    Route::get(config('statamic.routes.action').'/recaptcha/sitekey', function () {
        return response()->json(['sitekey' => config('recaptcha.sitekey')]);
    });
}
