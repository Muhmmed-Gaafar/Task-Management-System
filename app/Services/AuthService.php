<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\Response;

class AuthService
{
    use Response;
    public function register(array $data)
    {
        $user = new User();
        $user->email = $data['email'];
        $user->name= $data['name'];
        $user->password = Hash::make($data['password']);

        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = (new UserResource($user))->withToken($token);


        return $this->success(
            data: $data,
            message: 'you are registered successfully',
            status: 200
        );
    }

    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->failed(null, 'invalid credentials');
        }
        Auth::login($user);
        $token = $user->createToken('user_token')->plainTextToken;
        $data = (new UserResource($user))->withToken($token);

        return $this->success(
            data: $data,
            message: 'you are logged in successfully',
            status: 200,
        );
    }
}
