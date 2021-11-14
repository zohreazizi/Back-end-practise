<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreBusRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        return response()->json(['error type' => 'validation Error']);
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:buses',
            'plate_number' => 'required',
            'total_seats' => 'required',
            'company_name' => 'required'
        ];
    }

}
