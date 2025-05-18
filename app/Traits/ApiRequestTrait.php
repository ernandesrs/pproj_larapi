<?php

namespace App\Traits;

trait ApiRequestTrait
{
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if (\Request::is('api/*')) {
            $validator->after(function ($validator) {
                if ($validator->errors()->count()) {
                    session()->flash("validation_errors", $validator->errors());
                }
            });
        }
    }
}
