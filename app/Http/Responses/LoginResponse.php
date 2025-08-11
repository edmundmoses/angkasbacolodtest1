<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();

        if ($user->role === 'driver') {
            return redirect('/driver/dashboard');
        } elseif ($user->role === 'rider') {
            return redirect('/rider/dashboard');
        }

        return redirect('/dashboard');
    }
}
