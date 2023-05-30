<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends StoreCustomerRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $method = $this->method();
        if ($method == 'PUT' || $method == 'PATCH') {
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
        } else {
            return [
                //
                'name' => ['sometimes','required'],
                'type' => ['sometimes','required', Rule::in('I', 'B', 'i', 'b')],
                'email' => ['sometimes', 'required', 'email'],
                'address' => ['sometimes', 'required',],
                'city' => ['sometimes', 'required',],
                'state' => ['sometimes', 'required',],
                'postalCode' => ['sometimes', 'required',],
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge(['postal_code' => $this->postalCode,]);
    }
}
