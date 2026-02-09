<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Arr;
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

        if (! $user || ! Hash::check($password, $user->password)) {
            return null;
        }

        $token = $user->createToken($device_name)->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }
}
