<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $verification = $user->accountVerification;
        $emailVerified = (bool) ($verification?->email_verified);
        $phoneVerified = (bool) ($verification?->phone_verified);

        // For now, allow access when at least one verification is completed.
        if (! $emailVerified && ! $phoneVerified) {
            return redirect()->route('verify')->with('verify_notice', 'Please verify your account before making an offer or buying.');
        }

        return $next($request);
    }
}
