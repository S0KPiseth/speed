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
                <p id="otpTimerText" class="mt-2 text-xs font-medium text-amber-700">OTP expires in 01:00</p>

                <div class="mt-5">
                    <label class="mb-2 block text-sm font-medium text-zinc-700">Enter OTP</label>
                    <div id="otpInputsWrap" class="flex items-center gap-2 sm:gap-3">
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

            <div id="verifiedState" class="mt-6 hidden rounded-2xl border border-emerald-300 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                Phone verified.
            </div>

            <div id="feedbackLog" class="mt-6 hidden rounded-2xl border px-4 py-3 text-sm"></div>

            <script>
                const phoneStep = document.getElementById('phoneStep');
                const otpStep = document.getElementById('otpStep');
                const sendOtpButton = document.getElementById('sendOtpButton');
                const verifyOtpButton = document.getElementById('verifyOtpButton');
                const resendOtpButton = document.getElementById('resendOtpButton');
                const phoneInput = document.getElementById('phone');
                const countryCodeInput = document.getElementById('countryCode');
                const otpSentText = document.getElementById('otpSentText');
                const otpTimerText = document.getElementById('otpTimerText');
                const otpInputsWrap = document.getElementById('otpInputsWrap');
                const changePhoneButton = document.getElementById('changePhoneButton');
                const otpInputs = Array.from(document.querySelectorAll('.otp-input'));
                const feedbackLog = document.getElementById('feedbackLog');
                const verifiedState = document.getElementById('verifiedState');

                let otpTimer = null;
                let otpSecondsLeft = 0;

                function showFeedback(message, type = 'error') {
                    feedbackLog.classList.remove('hidden', 'border-red-300', 'bg-red-50', 'text-red-800', 'border-emerald-300', 'bg-emerald-50', 'text-emerald-800');
                    if (type === 'success') {
                        feedbackLog.classList.add('border-emerald-300', 'bg-emerald-50', 'text-emerald-800');
                    } else {
                        feedbackLog.classList.add('border-red-300', 'bg-red-50', 'text-red-800');
                    }
                    feedbackLog.textContent = message;
                }

                function clearFeedback() {
                    feedbackLog.classList.add('hidden');
                    feedbackLog.textContent = '';
                }

                function setButtonLoading(button, isLoading, loadingText, normalText) {
                    if (isLoading) {
                        button.disabled = true;
                        button.dataset.originalText = normalText;
                        button.textContent = loadingText;
                        button.classList.add('cursor-not-allowed', 'opacity-70');
                        return;
                    }

                    button.disabled = false;
                    button.textContent = button.dataset.originalText || normalText;
                    button.classList.remove('cursor-not-allowed', 'opacity-70');
                }

                function formatTimer(seconds) {
                    const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
                    const secs = String(seconds % 60).padStart(2, '0');
                    return `${mins}:${secs}`;
                }

                function stopOtpTimer() {
                    if (otpTimer) {
                        clearInterval(otpTimer);
                        otpTimer = null;
                    }
                }

                function startOtpTimer(seconds) {
                    stopOtpTimer();
                    otpSecondsLeft = seconds;
                    otpTimerText.textContent = `OTP expires in ${formatTimer(otpSecondsLeft)}`;

                    otpTimer = setInterval(function () {
                        otpSecondsLeft -= 1;

                        if (otpSecondsLeft <= 0) {
                            stopOtpTimer();
                            otpTimerText.textContent = 'OTP expired. Request a new OTP.';
                            showFeedback('OTP expired after 1 minute. Please resend OTP.', 'error');
                            return;
                        }

                        otpTimerText.textContent = `OTP expires in ${formatTimer(otpSecondsLeft)}`;
                    }, 1000);
                }

                function clearOtpInputs() {
                    otpInputs.forEach(function (input) {
                        input.value = '';
                    });
                }

                function getOtpValue() {
                    return otpInputs.map(function (input) {
                        return input.value;
                    }).join('');
                }

                function setOtpErrorState() {
                    otpInputs.forEach(function (input) {
                        input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                    });

                    otpInputsWrap.classList.remove('animate-otp-shake');
                    void otpInputsWrap.offsetWidth;
                    otpInputsWrap.classList.add('animate-otp-shake');
                }

                function clearOtpErrorState() {
                    otpInputs.forEach(function (input) {
                        input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-100');
                    });
                }

                function getFullPhoneNumber() {
                    const code = countryCodeInput.value.replace(/\s+/g, '');
                    const local = phoneInput.value.replace(/\s+/g, '');
                    return `${code}${local}`;
                }

                async function sendOtp() {
                    clearFeedback();
                    clearOtpErrorState();
                    verifiedState.classList.add('hidden');

                    const localPhone = phoneInput.value.trim();
                    if (!localPhone) {
                        showFeedback('Please enter your phone number.', 'error');
                        phoneInput.focus();
                        return;
                    }

                    const fullPhone = getFullPhoneNumber();

                    setButtonLoading(sendOtpButton, true, 'Sending...', 'Send OTP');

                    try {
                        const response = await fetch('{{ route('verify.phone.send') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ phone: fullPhone }),
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            phoneStep.classList.remove('hidden');
                            otpStep.classList.add('hidden');
                            showFeedback(data.message || 'Unable to send OTP. Please try again.', 'error');
                            return;
                        }

                        if (data.already_verified) {
                            phoneStep.classList.add('hidden');
                            otpStep.classList.add('hidden');
                            verifiedState.classList.remove('hidden');
                            showFeedback(data.message || 'Phone already verified.', 'success');
                            return;
                        }

                        otpSentText.textContent = `We sent a 6-digit OTP to ${fullPhone}.`;
                        phoneStep.classList.add('hidden');
                        otpStep.classList.remove('hidden');
                        clearOtpInputs();
                        startOtpTimer(Number(data.expires_in || 60));
                        otpInputs[0].focus();
                        showFeedback(data.message || 'OTP sent successfully.', 'success');
                    } catch (error) {
                        phoneStep.classList.remove('hidden');
                        otpStep.classList.add('hidden');
                        showFeedback('Network error while sending OTP. Please try again.', 'error');
                    } finally {
                        setButtonLoading(sendOtpButton, false, 'Sending...', 'Send OTP');
                    }
                }

                async function verifyOtp() {
                    clearFeedback();
                    clearOtpErrorState();

                    const otp = getOtpValue();
                    if (otp.length !== 6) {
                        setOtpErrorState();
                        showFeedback('Please enter the 6-digit OTP code.', 'error');
                        otpInputs[0].focus();
                        return;
                    }

                    setButtonLoading(verifyOtpButton, true, 'Verifying...', 'Verify Phone');
                    resendOtpButton.disabled = true;
                    resendOtpButton.classList.add('cursor-not-allowed', 'opacity-70');

                    try {
                        const response = await fetch('{{ route('verify.phone.confirm') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ otp }),
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            setOtpErrorState();
                            showFeedback(data.message || 'OTP verification failed.', 'error');
                            return;
                        }

                        stopOtpTimer();
                        otpStep.classList.add('hidden');
                        phoneStep.classList.add('hidden');
                        verifiedState.classList.remove('hidden');
                        showFeedback(data.message || 'Phone verified successfully.', 'success');
                    } catch (error) {
                        setOtpErrorState();
                        showFeedback('Network error while verifying OTP. Please try again.', 'error');
                    } finally {
                        setButtonLoading(verifyOtpButton, false, 'Verifying...', 'Verify Phone');
                        resendOtpButton.disabled = false;
                        resendOtpButton.classList.remove('cursor-not-allowed', 'opacity-70');
                    }
                }

                sendOtpButton.addEventListener('click', sendOtp);
                resendOtpButton.addEventListener('click', sendOtp);
                verifyOtpButton.addEventListener('click', verifyOtp);

                changePhoneButton.addEventListener('click', function () {
                    stopOtpTimer();
                    clearFeedback();
                    clearOtpErrorState();
                    otpStep.classList.add('hidden');
                    phoneStep.classList.remove('hidden');
                    phoneInput.focus();
                });

                otpInputs.forEach(function (input, index) {
                    input.addEventListener('input', function (event) {
                        clearOtpErrorState();
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

            <style>
                @keyframes otp-shake {
                    0% { transform: translateX(0); }
                    20% { transform: translateX(-5px); }
                    40% { transform: translateX(5px); }
                    60% { transform: translateX(-4px); }
                    80% { transform: translateX(4px); }
                    100% { transform: translateX(0); }
                }

                .animate-otp-shake {
                    animation: otp-shake 0.35s ease-in-out;
                }
            </style>
        </div>
    </div>
</div>
@endsection
