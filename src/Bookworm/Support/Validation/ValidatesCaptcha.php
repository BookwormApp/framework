<?php

namespace Bookworm\Support\Validation;

use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use ReCaptcha\ReCaptcha;

trait ValidatesCaptcha
{
    public function validateCaptcha(Request $request)
    {
        if (app()->environment('testing')) {
            return true;
        }

        if (config('site.captcha') == false) {
            return true;
        }

        $recaptcha = new ReCaptcha(config('services.recaptcha.secret'));
        $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        if (!$response->isSuccess()) {
            throw new ValidationException(
                new MessageBag([
                    'recaptcha' => 'The captcha was not correct',
                ])
            );
        }

        return true;
    }
}
