@extends('home.index')
@section('layoutContent')
@php
    $accountVerification = auth()->user()?->accountVerification;
    $emailVerified = (bool) ($accountVerification?->email_verified);
    $phoneVerified = (bool) ($accountVerification?->phone_verified);
    $idVerificationStatus = auth()->user()?->idVerificationRequest?->status;
    $idVerificationPending = ($idVerificationStatus === 'pending');
    $idVerificationApproved = ($idVerificationStatus === 'approved');
    $idVerificationRejected = ($idVerificationStatus === 'rejected');
@endphp

<div class="min-h-screen flex flex-col">
    <x-nav-bar class="opacity-0"></x-nav-bar>
    <div class="grow flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-4xl text-center">
            <p class="text-4xl font-bold text-zinc-900">Verification Status</p>
            <p class="mt-4 text-base text-zinc-600">Complete one of the options below to continue using your account without limits.</p>
            <p class="mt-1 text-sm text-zinc-500">This verification helps protect your account and keeps your profile trusted by other users.</p>

            <div class="mt-8 flex flex-row items-stretch justify-center gap-4 overflow-x-auto pb-2">
                <x-verification-option-button
                    title="Email Verification"
                    subtitle="Confirm your email to secure account recovery and notifications."
                    :disabled="$emailVerified"
                    :verified="$emailVerified"
                    href="{{ route('verify.email') }}"
                >
                    <x-slot:icon>
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M4 7h16v10H4z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            <path d="m4 8 8 6 8-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </x-slot:icon>
                </x-verification-option-button>

                <x-verification-option-button
                    title="Phone Number Verification"
                    subtitle="Verify your number to receive login codes and security alerts."
                    :disabled="$phoneVerified"
                    :verified="$phoneVerified"
                    href="{{ route('verify.phone') }}"
                >
                    <x-slot:icon>
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M8 3h8v18H8z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            <path d="M11 18h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </x-slot:icon>
                </x-verification-option-button>

                <x-verification-option-button
                    title="ID Verification"
                    subtitle="Upload a valid ID to confirm identity and increase account trust."
                    :verified="$idVerificationApproved"
                    :pending="$idVerificationPending"
                    :rejected="$idVerificationRejected"
                    href="{{ route('verify.document') }}"
                >
                    <x-slot:icon>
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.5" />
                            <circle cx="8" cy="12" r="2" stroke="currentColor" stroke-width="1.5" />
                            <path d="M13 10h5M13 13h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </x-slot:icon>
                </x-verification-option-button>
            </div>
        </div>
    </div>

</div>
@endsection
