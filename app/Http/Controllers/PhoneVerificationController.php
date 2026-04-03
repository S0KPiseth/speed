<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PhoneVerificationController
{
    public function send(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => 'You must be logged in to request phone verification.',
            ], 401);
        }

        if ((bool) ($user->accountVerification?->phone_verified)) {
            VerificationRequest::query()
                ->where('user_id', $user->id)
                ->where('type', 'phone')
                ->delete();

            return response()->json([
                'message' => 'Your phone is already verified.',
                'already_verified' => true,
            ]);
        }

        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:30'],
        ]);

        VerificationRequest::query()
            ->where('user_id', $user->id)
            ->where('type', 'phone')
            ->where('expires_at', '<', now())
            ->delete();

        VerificationRequest::query()
            ->where('user_id', $user->id)
            ->where('type', 'phone')
            ->delete();

        $otp = (string) random_int(100000, 999999);

        $verificationRequest = VerificationRequest::query()->create([
            'user_id' => $user->id,
            'type' => 'phone',
            'secret_code' => $otp,
            'expires_at' => now()->addMinute(),
        ]);

        $response = Http::withHeaders([
            'api-key' => (string) config('services.brevo.key'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post(rtrim((string) config('services.brevo.url'), '/') . '/transactionalSMS/sms', [
            'sender' => (string) config('services.brevo.sms_sender', config('app.name', 'Prime Motor')),
            'recipient' => $validated['phone'],
            'content' => 'Your verification OTP is ' . $otp . '. It expires in 1 minute.',
            'type' => 'transactional',
        ]);

        if (! $response->successful()) {
            $verificationRequest->delete();

            return response()->json([
                'message' => $this->resolveBrevoError($response->json()) ?: 'Unable to send OTP right now. Please try again.',
            ], 502);
        }

        return response()->json([
            'message' => 'OTP sent successfully.',
            'expires_in' => 60,
            'phone' => $validated['phone'],
        ]);
    }

    public function confirm(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => 'You must be logged in to verify your phone.',
            ], 401);
        }

        if ((bool) ($user->accountVerification?->phone_verified)) {
            VerificationRequest::query()
                ->where('user_id', $user->id)
                ->where('type', 'phone')
                ->delete();

            return response()->json([
                'message' => 'Phone already verified.',
                'already_verified' => true,
            ]);
        }

        $validated = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        VerificationRequest::query()
            ->where('user_id', $user->id)
            ->where('type', 'phone')
            ->where('expires_at', '<', now())
            ->delete();

        $verificationRequest = VerificationRequest::query()
            ->where('user_id', $user->id)
            ->where('type', 'phone')
            ->latest('id')
            ->first();

        if (! $verificationRequest) {
            return response()->json([
                'message' => 'OTP expired or not found. Please request a new OTP.',
            ], 422);
        }

        if (now()->greaterThan($verificationRequest->expires_at)) {
            $verificationRequest->delete();

            return response()->json([
                'message' => 'OTP expired after 1 minute. Please request a new OTP.',
            ], 422);
        }

        $verificationRequest->increment('attempts');

        if ((string) $verificationRequest->secret_code !== (string) $validated['otp']) {
            return response()->json([
                'message' => 'Invalid OTP code. Please check and try again.',
            ], 422);
        }

        $accountVerification = $user->accountVerification()->firstOrCreate();
        $accountVerification->phone_verified = true;
        $accountVerification->save();

        $verificationRequest->delete();

        return response()->json([
            'message' => 'Phone verified successfully.',
            'verified' => true,
        ]);
    }

    private function resolveBrevoError(mixed $payload): ?string
    {
        if (! is_array($payload)) {
            return null;
        }

        if (isset($payload['message']) && is_string($payload['message'])) {
            return $payload['message'];
        }

        if (isset($payload['code'], $payload['message']) && is_string($payload['code']) && is_string($payload['message'])) {
            return $payload['code'] . ': ' . $payload['message'];
        }

        return null;
    }
}
