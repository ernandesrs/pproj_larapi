<?php

namespace App\Http\Requests;

use App\Traits\ApiRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
    public function prepareForValidation()
    {
        if (!$this->get('remember')) {
            $this->merge([
                'remember' => false
            ]);
        }

        $tokenName = $this->header('X-Token-Name', 'default');
        $this->merge([
            'token_name' => in_array($tokenName, ['default', 'webapp', 'mobileapp']) ? $tokenName : 'default'
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'token_name' => ['required', 'string'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean']
        ];
    }
}
