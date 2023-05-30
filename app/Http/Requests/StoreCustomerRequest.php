<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('create');
    }

    public function rules()
    {
        return [
            //
            'name' => ['required'],
            'type' => ['required', Rule::in('I', 'B', 'i', 'b')],
            'email' => ['required', 'email'],
            'address' => ['required',],
            'city' => ['required',],
            'state' => ['required',],
            'postalCode' => ['required',],
        ];
    }

    protected function prepareForValidation()
    {
        if($this->postalCode) {
            $this->merge(['postal_code' => $this->postalCode,]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json($validator->errors(), 422));
    }
}
