<?php

namespace App\Http\Requests;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'departure_place' => 'required',
            'departure_date' => 'required',
            'departure_time' => 'required',
            'arrival_place' => 'required',
            'arrival_date' => 'required',
            'arrival_time' => 'required',
            'remaining_capacity' => 'required',
            'bus_id' => 'required'
        ];
    }
}
