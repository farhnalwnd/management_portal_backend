<?php

namespace App\Http\Service;

use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

        if ($user->status !== 'active') {
            return 'user not active';
        }

        if (! Hash::check($password, $user->password)) {
            return 'password not match';
        }

        $token = $user->createToken($device_name)->plainTextToken;

        // Parameter Cookie::make($name, $value, $minutes, $path, $domain, $secure, $httpOnly, $raw, $sameSite)
        $cookie = Cookie::make('portal_access_token', $token, 0, '/', null, true, true, false, 'none');

        return [
            'user' => new UserResource($user),
            'token' => $token,
            'cookie' => $cookie,
        ];
    }

    public function getUserLogin()
    {
        $user = Auth::user();
        if (! $user) {
            return 'user not found';
        }

        return $user;
    }
}
