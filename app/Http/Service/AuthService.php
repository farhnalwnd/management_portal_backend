<?php

namespace App\Http\Service;

use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $data): array|string
    {
        ['email' => $email, 'password' => $password, 'device_name' => $device_name] = $data;

        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            throw new \Exception('user not found');
        }

        if ($user->status !== 'active') {
            throw new \Exception('user not active');
        }

        if (!Hash::check($password, $user->password)) {
            throw new \Exception('password not match');
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

    public function getUserLogin(): ?User
    {
        $user = Auth::user();

        return $user instanceof User ? $user : null;
    }
}
