<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EnsureResetTokenValid
{
    public function handle($request, Closure $next)
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.forgot');
        }

        $user = User::where('email', $email)
            ->whereNotNull('reset_token')
            ->first();

        if (
            !$user ||
            !$user->reset_token_expires_at ||
            now()->greaterThan($user->reset_token_expires_at)
        ) {
            return redirect()->route('password.forgot');
        }

        return $next($request);
    }
}