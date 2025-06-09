<?php

namespace App\Http\Requests;

use App\Rules\UserRules;
use App\Traits\ApiRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $rules = UserRules::updateRules(\Auth::user());

        unset($rules['email']);

        return $rules;
    }
}
