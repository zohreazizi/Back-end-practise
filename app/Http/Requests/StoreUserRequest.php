<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:55|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ];
    }

//    public function response(array $errors)
//    {
//        $transformed = [];
//
//        foreach ($errors as $field => $message) {
//            $transformed[] = [
//                'field' => $field,
//                'message' => $message[0]
//            ];
//        }
//
//        return response()->json([
//            'errors' => $transformed
//        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
//    }
}
