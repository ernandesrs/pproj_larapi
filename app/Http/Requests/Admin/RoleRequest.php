<?php

namespace App\Http\Requests\Admin;

use App\Rules\RoleRules;
use App\Traits\ApiRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    use ApiRequestTrait;

    /**
     * Prepare for validation
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'guard_name' => $this->get('guard_name', 'web'),
            'admin_access' => $this->get('admin_access', false)
        ]);
    }

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
        return $this->role ?
            RoleRules::updateRules($this->role, []) :
            RoleRules::creationRules();
    }
}
