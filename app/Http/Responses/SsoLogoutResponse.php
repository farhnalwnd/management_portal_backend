<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Illuminate\Http\RedirectResponse;

class SsoLogoutResponse implements LogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        $portalUrl = config('services.sso.portal_url');

        return redirect()->to($portalUrl);
    }
}