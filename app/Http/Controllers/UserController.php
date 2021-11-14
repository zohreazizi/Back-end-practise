<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        try {
            $data = $request->only('name', 'email', 'password');
            $validator = $request->validated();

            // if there are some error's, show them to user
            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 422);
            }
            $data['password'] = bcrypt($request->password);
            $user = User::create($data);
            //generate token
            $token = $user->createToken('NewToken')->accessToken;
            return response()->json([
                'status' => 'success',
                'message' => 'Saved successfully',
                'response' => [
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'name' => request('name'), 'password' => request('password')])) {
            $token = auth()->user()->createToken('NewToken')->accessToken;
            return response()->json([
                'status' => 'success',
                'message' => "You're authorized",
                'code' => 200,
                'response' => [
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized']);
        }
    }

    public function info()
    {
//        $information = 'this is just for test';
//        $roles = User::with('roles')->get();
        $user = auth('api')->user();

$role = $user->roles()->pluck('name');



        return response()->json(['info' => 'hi']);
    }
}
