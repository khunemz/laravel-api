<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
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
        $this->merge(['postal_code' => $this->postalCode,]);
    }
}
