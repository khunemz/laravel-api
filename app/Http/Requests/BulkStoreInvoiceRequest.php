<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BulkStoreInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            //
            '*.customerId' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'],
            '*.status' => ['required', Rule::in('B', 'P', 'V', 'b', 'p', 'v')],
            '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDate' => ['date_format:Y-m-d H:i:s', 'nullable']
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['amount'] = $obj['amount'] ?? null;
            $obj['status'] = $obj['status'] ?? null;
            $obj['billed_date'] = $obj['billedDate'] ?? null;
            $obj['paid_date'] = $obj['paidDate'] ?? null;

            $data[] = $obj;
        }
        $this->merge($data);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json($validator->errors(), 422));
    }
}
