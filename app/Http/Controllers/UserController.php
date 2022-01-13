<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Throwable;
use App\Models\User;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    use Responses;

    public function register(StoreUserRequest $request)
    {
        try {
            $data = $request->only('name', 'email', 'password');
            $data['password'] = bcrypt($request->password);
            $user = User::create($data);

            // all new users get the default value of "costumer" for their first role
            $user->roles()->attach(4);

            //generate token
            $token = $user->createToken('NewToken')->accessToken;
            return $this->success(['token' => $token, 'token_type' => 'Bearer'],
                'Saved successfully', 200);
        } catch (Throwable $e) {
            //TODO code?
            return $this->failure($e->getMessage(), 401);
        }
    }

    public function login(Request $request)
    {
        try {
            if (Auth::attempt(['email' => request('email'),
                'name' => request('name'), 'password' => request('password')])) {
                $token = auth()->user()->createToken('NewToken')->accessToken;
                return $this->success(['token' => $token, 'token_type' => 'Bearer'], "You're in!", 200);
            } else {
                return $this->failure('You are not authenticated', 401);
            }
        } catch (Throwable $e) {
            return $this->failure($e->getMessage(), 401);
        }
    }

    public function landingPageInfo()
    {
        try {
        $user = User::query()->find(1)->roles;
            $comments = User::query()->whereNotNull('comment')
                ->select('comment', 'name')->pluck('comment' , 'name');
            return $this->success($comments,'comments',200);
        }catch (Throwable $e){
            return $this->failure($e->getMessage(), 401);
        }
    }
}
