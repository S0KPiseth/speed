<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EmailVerificationController
{
    public function show(Request $request)
    {
        $token = (string) $request->query('token', '');

        if ($token === '' && ! Auth::check()) {
            return redirect()->route('login');
        }

        $authenticatedUser = Auth::user();
        $authenticatedAlreadyVerified = (bool) ($authenticatedUser?->accountVerification?->email_verified);

        // If logged-in user is already verified, skip token flow and loading state entirely.
        if ($authenticatedAlreadyVerified) {
            return view('pages.verify.email', [
                'user' => $authenticatedUser,
                'token' => '',
                'verified' => false,
                'alreadyVerified' => true,
                'tokenError' => null,
            ]);
        }

        return view('pages.verify.email', [
            'user' => $authenticatedUser,
            'token' => $token,
            'verified' => (bool) $request->boolean('verified'),
            'alreadyVerified' => $authenticatedAlreadyVerified || (bool) $request->boolean('already_verified'),
            'tokenError' => $request->query('token_error'),
        ]);
    }

    public function send(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => 'You must be logged in to request email verification.',
            ], 401);
        }

        if ((bool) ($user->accountVerification?->email_verified)) {
            VerificationRequest::query()
                ->where('user_id', $user->id)
                ->where('type', 'email')
                ->delete();

            return response()->json([
                'message' => 'Your email is already verified.',
                'already_verified' => true,
            ]);
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        if (mb_strtolower($validated['email']) !== mb_strtolower((string) $user->email)) {
            return response()->json([
                'message' => 'Please use your account email address to verify your account.',
            ], 422);
        }

        VerificationRequest::query()
            ->where('user_id', $user->id)
            ->where('type', 'email')
            ->delete();

        $token = Str::random(64);

        $verificationRequest = VerificationRequest::query()->create([
            'user_id' => $user->id,
            'type' => 'email',
            'secret_code' => $token,
            'expires_at' => now()->addMinutes(30),
        ]);

        $verificationLink = url('/verify/email?token=' . urlencode($token));

        $response = Http::withHeaders([
            'api-key' => (string) config('services.brevo.key'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post(rtrim((string) config('services.brevo.url'), '/') . '/smtp/email', [
            'sender' => [
                'name' => (string) config('services.brevo.sender.name'),
                'email' => (string) config('services.brevo.sender.email'),
            ],
            'to' => [[
                'email' => $validated['email'],
                'name' => $user->username,
            ]],
            'subject' => 'Verify your email address',
            'htmlContent' => '<p>Hello ' . e((string) $user->username) . ',</p>'
                . '<p>Click the link below to verify your email address:</p>'
                . '<p><a href="' . e($verificationLink) . '">Verify Email</a></p>'
                . '<p>This link expires in 30 minutes.</p>',
        ]);

        if (! $response->successful()) {
            $verificationRequest->delete();

            return response()->json([
                'message' => 'Unable to send verification email right now. Please try again.',
            ], 502);
        }

        return response()->json([
            'message' => 'Verification email sent successfully.',
            'email' => $validated['email'],
        ]);
    }

    public function confirm(Request $request)
    {
        $token = (string) $request->query('token', '');

        if ($token === '') {
            return redirect()->route('verify.email', [
                'token_error' => 'Verification token is missing.',
                'verification_result' => 'failed',
            ]);
        }

        $verificationRequest = VerificationRequest::query()
            ->where('type', 'email')
            ->where('secret_code', $token)
            ->first();

        if (! $verificationRequest) {
            return redirect()->route('verify.email', [
                'token_error' => 'Verification link is invalid or already used.',
                'verification_result' => 'failed',
            ]);
        }

        if (now()->greaterThan($verificationRequest->expires_at)) {
            $verificationRequest->delete();

            return redirect()->route('verify.email', [
                'token_error' => 'Verification link expired. Please request a new verification email.',
                'verification_result' => 'failed',
            ]);
        }

        $verificationRequest->increment('attempts');
        $user = $verificationRequest->user;

        if (! $user) {
            $verificationRequest->delete();

            return redirect()->route('verify.email', [
                'token_error' => 'Account not found for this verification link.',
                'verification_result' => 'failed',
            ]);
        }

        $accountVerification = $user->accountVerification()->firstOrCreate();

        if ((bool) $accountVerification->email_verified) {
            $verificationRequest->delete();

            return redirect()->route('verify.email', ['already_verified' => 1]);
        }

        $accountVerification->email_verified = true;
        $accountVerification->save();

        $verificationRequest->delete();

        return redirect()->route('verify.email', ['verified' => 1]);
    }
}
