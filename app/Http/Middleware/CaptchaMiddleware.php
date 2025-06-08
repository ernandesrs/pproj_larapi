<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptchaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->captchaCheck($request);
        return $next($request);
    }

    /**
     * Captcha check
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function captchaCheck(Request $request): void
    {
        // When false, there is no check
        if (!env('ENABLE_CAPTCHA')) {
            return;
        }

        $validated = \Validator::make([
            'captcha_verification' => $request->get('captcha_verification')
        ], [
            'captcha_verification' => ['nullable', 'string']
        ])->validated();

        if (!$validated['captcha_verification']) {
            $this->dispatchCaptchaValidationError('Missing required capatcha');
        }

        $response = \Http::post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('CLOUDFLARE_CAPTCHA_SECRET'),
            'response' => $validated['captcha_verification'],
            'remoteip' => \Request::ip(),
        ]);

        if (!$response->json('success')) {
            $this->dispatchCaptchaValidationError('Invalid capatcha');
        }
    }

    /**
     * Dispatch Captcha Validation Error
     * @throws \Illuminate\Validation\ValidationException
     * @return never
     */
    private function dispatchCaptchaValidationError(string $message)
    {
        session()->flash("validation_errors", [
            'captcha_verification' => $message
        ]);
        throw (new \Illuminate\Validation\ValidationException(\Validator::make([], [])));
    }
}
