<?php

namespace App\Http\Requests;

use App\Traits\ApiRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class PasswordForgetRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email']
        ];
    }

    /**
     * Messages
     * @return array{email.exists: string}
     */
    public function messages(): array
    {
        return [
            'email.exists' => 'E-mail não encontrado nos registros'
        ];
    }
}
