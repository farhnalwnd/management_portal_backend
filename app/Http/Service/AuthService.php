<?php

namespace App\Http\Service;

use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function login(array $data)
    {
        ['email' => $email, 'password' => $password, 'device_name' => $device_name] = $data;

        $user = User::where('email', $email)->first();

        if (! $user) {
            return 'user not found';
        }

        if (! Hash::check($password, $user->password)) {
            return 'password not match';
        }

        $token = $user->createToken($device_name)->plainTextToken;

        return [
            'user'  => new UserResource($user),
            'token' => $token,
        ];
    }
}
