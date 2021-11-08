<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required|max:55|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);

            // if there are some error's, show them to user
            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 422);
            }
            $data['password'] = bcrypt($request->password);
            $user = User::create($data);
            //generate token
            $token = $user->createToken('NewToken')->accessToken;
            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer'
            ]);
        }catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $token = auth()->user()->createToken('NewToken')->accessToken;
            return response()->json([
                'token' => $token,
                'code' => 200
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized']);
        }
    }
}
