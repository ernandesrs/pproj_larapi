<?php

namespace App\Http\Requests;

use App\Rules\PasswordRules;
use App\Traits\ApiRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class ForgetedPasswordUpdateRequest extends FormRequest
{
    use ApiRequestTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare for validation
     * @return void
     */
    public function prepareForValidation(): void
    {
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array{code: array<(callable(mixed ,mixed ,mixed ):void)|string>, email: string[]}
     */
    public function rules(): array
    {
        return [
            ...PasswordRules::updateRules(),
            'email' => ['required', 'email', 'exists:users,email'],
            'code' => [
                'required',
                'string',
                function ($attr, $value, $fail) {
                    if (
                        !(is_string($this->email) && filter_var($this->email, FILTER_VALIDATE_EMAIL)) ||
                        !is_string($value)
                    ) {
                        return;
                    }

                    $passwordReset = \DB::table('password_reset_tokens')
                        ->where('email', $this->email)
                        ->where('token', $value)->first();

                    if (!$passwordReset) {
                        $fail('Invalid update code.');
                        return;
                    }

                    $createdAt = \Illuminate\Support\Carbon::parse($passwordReset->created_at);
                    if ($createdAt->addMinutes(5) < now()) {
                        $fail('Expired update code.');
                    }
                }
            ],
        ];
    }

    /**
     * Messages
     * @return array{code.exists: string}
     */
    public function messages(): array
    {
        return [
            'code.exists' => 'Invalid recovery code.'
        ];
    }
}
