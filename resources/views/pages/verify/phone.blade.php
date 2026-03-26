@extends('home.index')
@section('layoutContent')
<div class="min-h-screen bg-zinc-50 relative overflow-hidden">
    <div class="pointer-events-none absolute -top-24 -left-16 h-64 w-64 rounded-full bg-sky-100 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-16 -right-10 h-72 w-72 rounded-full bg-emerald-100 blur-3xl"></div>
    <x-nav-bar class="opacity-0"></x-nav-bar>

    <div class="mx-auto flex w-full max-w-3xl items-center justify-center px-4 py-12 relative z-10">
        <div class="w-full rounded-3xl border border-zinc-200 bg-white/95 p-8 shadow-[0_20px_70px_-35px_rgba(0,0,0,0.35)] backdrop-blur">
            <div class="mb-6">
                <a href="{{ route('verify') }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-800">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M15 6 9 12l6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Back to verification options
                </a>
            </div>

            <div class="mb-8">
                <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">Account verification</p>
                <h1 class="mt-2 text-3xl font-semibold text-zinc-900">Phone Number Verification</h1>
                <p class="mt-3 text-sm text-zinc-600">Confirm your phone number with OTP verification for faster account recovery and login security.</p>
            </div>

            <div id="phoneStep" class="space-y-5">
                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-zinc-700">Phone Number</label>
                    <div class="flex gap-2">
                        <input id="countryCode" type="text" value="+855" class="w-24 rounded-xl border border-zinc-200 px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-400">
                        <input id="phone" type="tel" placeholder="12 345 678" class="w-full rounded-xl border border-zinc-200 px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-400">
                    </div>
                </div>

                <div class="pt-2 text-right">
                    <button id="sendOtpButton" type="button" class="rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">Send OTP</button>
                </div>
            </div>

            <div id="otpStep" class="hidden">
                <p id="otpSentText" class="text-sm text-zinc-600">We sent a 6-digit OTP to your phone number.</p>

                <div class="mt-5">
                    <label class="mb-2 block text-sm font-medium text-zinc-700">Enter OTP</label>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input h-12 w-12 rounded-xl border border-zinc-200 text-center text-lg font-semibold text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-200">
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input h-12 w-12 rounded-xl border border-zinc-200 text-center text-lg font-semibold text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-200">
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input h-12 w-12 rounded-xl border border-zinc-200 text-center text-lg font-semibold text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-200">
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input h-12 w-12 rounded-xl border border-zinc-200 text-center text-lg font-semibold text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-200">
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input h-12 w-12 rounded-xl border border-zinc-200 text-center text-lg font-semibold text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-200">
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input h-12 w-12 rounded-xl border border-zinc-200 text-center text-lg font-semibold text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-200">
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <button id="changePhoneButton" type="button" class="text-sm text-zinc-500 underline underline-offset-4 transition hover:text-zinc-700">Change phone number</button>
                    <div class="flex items-center gap-3">
                        <button id="resendOtpButton" type="button" class="rounded-xl border border-zinc-300 px-4 py-3 text-sm font-medium text-zinc-700 transition hover:border-zinc-500 hover:text-zinc-900">Resend OTP</button>
                        <button id="verifyOtpButton" type="button" class="rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">Verify Phone</button>
                    </div>
                </div>
            </div>

            <script>
                const phoneStep = document.getElementById('phoneStep');
                const otpStep = document.getElementById('otpStep');
                const sendOtpButton = document.getElementById('sendOtpButton');
                const phoneInput = document.getElementById('phone');
                const countryCodeInput = document.getElementById('countryCode');
                const otpSentText = document.getElementById('otpSentText');
                const changePhoneButton = document.getElementById('changePhoneButton');
                const otpInputs = Array.from(document.querySelectorAll('.otp-input'));

                sendOtpButton.addEventListener('click', function () {
                    const phoneValue = phoneInput.value.trim();

                    if (!phoneValue) {
                        phoneInput.focus();
                        return;
                    }

                    otpSentText.textContent = `We sent a 6-digit OTP to ${countryCodeInput.value.trim()} ${phoneValue}.`;
                    phoneStep.classList.add('hidden');
                    otpStep.classList.remove('hidden');
                    otpInputs[0].focus();
                });

                changePhoneButton.addEventListener('click', function () {
                    otpStep.classList.add('hidden');
                    phoneStep.classList.remove('hidden');
                    phoneInput.focus();
                });

                otpInputs.forEach(function (input, index) {
                    input.addEventListener('input', function (event) {
                        const value = event.target.value.replace(/\D/g, '');
                        event.target.value = value;

                        if (value && index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    });

                    input.addEventListener('keydown', function (event) {
                        if (event.key === 'Backspace' && !event.target.value && index > 0) {
                            otpInputs[index - 1].focus();
                        }
                    });

                    input.addEventListener('paste', function (event) {
                        event.preventDefault();
                        const pastedData = (event.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, otpInputs.length);

                        pastedData.split('').forEach(function (digit, digitIndex) {
                            otpInputs[digitIndex].value = digit;
                        });

                        const nextIndex = Math.min(pastedData.length, otpInputs.length - 1);
                        otpInputs[nextIndex].focus();
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection
