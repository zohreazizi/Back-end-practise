<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreRideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        return response()->json(['error type' => 'validation Error']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'departure_place' => 'required',
            'departure_date' => 'required|date_format:Y-m-d',
            'departure_time' => 'required',
            'arrival_place' => 'required',
            'arrival_date' => 'required|after:departure_date|date_format:Y-m-d',
            'arrival_time' => 'required|after:departure_time',
            'remaining_capacity' => 'required',
            'bus_id' => 'required|integer',
            'price' => 'required|integer'
        ];
    }
}
