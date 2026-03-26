@extends('home.index')
@section('layoutContent')
@php
    $hasToken = filled($token ?? null);
    $isVerified = (bool) ($verified ?? false);
    $alreadyVerified = (bool) ($alreadyVerified ?? false);
    $tokenErrorMessage = $tokenError ?? null;
    $isResultState = $hasToken || $isVerified || $alreadyVerified || filled($tokenErrorMessage);
@endphp
<div class="min-h-screen bg-zinc-50 relative overflow-hidden">
    <div class="pointer-events-none absolute -top-24 -left-16 h-64 w-64 rounded-full bg-emerald-100 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-16 -right-10 h-72 w-72 rounded-full bg-cyan-100 blur-3xl"></div>
    <x-nav-bar class="opacity-0"></x-nav-bar>

    @if ($tokenErrorMessage)
        <div class="fixed top-15 right-4 z-[9999] flex flex-col gap-y-1.5 pointer-events-none">
            <div class="pointer-events-auto">
                <x-feedback-log :error="$tokenErrorMessage"></x-feedback-log>
            </div>
        </div>
    @endif

    <div class="mx-auto flex w-full max-w-3xl items-center justify-center px-4 py-12 relative z-10">
        <div class="w-full rounded-3xl border border-zinc-200 bg-white/95 p-8 shadow-[0_20px_70px_-35px_rgba(0,0,0,0.35)] backdrop-blur">
            @if ($isResultState)
                <div class="mb-6">
                    <a href="{{ route('verify') }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-800">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M15 6 9 12l6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Back to verification options
                    </a>
                </div>

                @if (! $alreadyVerified && ! $isVerified && ! $tokenErrorMessage)
                    <div class="mb-8 text-center">
                        <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">Account verification</p>
                        <h1 class="mt-2 text-3xl font-semibold text-zinc-900">Verifying Email</h1>
                        <p class="mt-3 text-sm text-zinc-600">Please wait while we verify your email link.</p>
                    </div>
                @endif

                @if ($alreadyVerified)
                    <div class="text-center">
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Already Verified</p>
                        <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Email Already Verified</h2>
                        <p class="mt-3 text-sm text-zinc-600">Your email has already been verified. No further action is needed.</p>
                        <div class="mt-7">
                            <a href="{{ route('verify') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">
                                Return to Verification Page
                            </a>
                        </div>
                    </div>
                @elseif ($tokenErrorMessage)
                    <div class="mb-8 text-center">
                        <p class="text-xs uppercase tracking-[0.2em] text-red-600">Verification Failed</p>
                        <h1 class="mt-2 text-3xl font-semibold text-zinc-900">Unable to Verify Email</h1>
                        <p class="mt-3 text-sm text-zinc-600">Your verification link is not valid anymore.</p>
                    </div>
                    <div class="mt-7 text-center">
                        <a href="{{ route('verify.email') }}" class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-5 py-3 text-sm font-medium text-zinc-700 transition hover:border-zinc-500 hover:text-zinc-900">
                            Request New Verification Email
                        </a>
                    </div>
                @elseif ($isVerified)
                    <div class="text-center">
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Success</p>
                        <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Email Verified</h2>
                        <p class="mt-3 text-sm text-zinc-600">Your email is now verified and your account is updated.</p>
                        <div class="mt-7">
                            <a href="{{ route('verify') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">
                                Return to Verification Page
                            </a>
                        </div>
                    </div>
                @else
                    <div id="tokenLoadingState" class="flex flex-col items-center justify-center py-8">
                        <div class="h-12 w-12 animate-spin rounded-full border-4 border-zinc-200 border-t-zinc-900"></div>
                        <p class="mt-4 text-sm text-zinc-600">Verifying your link...</p>
                    </div>

                    <script>
                        window.setTimeout(function () {
                            window.location.href = "{{ route('verify.email.confirm', ['token' => $token]) }}";
                        }, 1000);
                    </script>
                @endif
            @else
                <div class="mb-6">
                    <a href="{{ route('verify') }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-800">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M15 6 9 12l6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Back to verification options
                    </a>
                </div>

                @if ($alreadyVerified)
                    <div class="text-center">
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Already Verified</p>
                        <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Email Already Verified</h2>
                        <p class="mt-3 text-sm text-zinc-600">Your email is already verified, so you do not need to request another link.</p>
                        <div class="mt-7">
                            <a href="{{ route('verify') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">
                                Back to Verification Options
                            </a>
                        </div>
                    </div>
                @else
                    <div id="emailFormState" class="">
                        <div class="mb-8">
                            <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">Account verification</p>
                            <h1 class="mt-2 text-3xl font-semibold text-zinc-900">Email Verification</h1>
                            <p class="mt-3 text-sm text-zinc-600">Enter your email and we will send a verification link to confirm your account.</p>
                        </div>

                        <div id="emailErrorState" class="hidden mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"></div>

                        <form id="emailVerificationForm" class="space-y-5">
                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-zinc-700">Email Address</label>
                                <input id="email" name="email" type="email" value="{{ auth()->user()?->email }}" placeholder="you@example.com" required class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-200">
                            </div>

                            <div class="pt-2 text-right">
                                <button id="sendVerificationButton" type="submit" class="rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">Send Verification Email</button>
                            </div>
                        </form>
                    </div>
                @endif

                <div id="emailSuccessState" class="hidden">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Success</p>
                    <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Verification Email Sent</h2>
                    <p id="emailSuccessMessage" class="mt-3 text-sm text-zinc-600">
                        Success. The verification email has been sent to your inbox.
                    </p>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a id="openEmailButton" href="https://mail.google.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">
                            Open Email
                        </a>
                        <button id="sendAnotherButton" type="button" class="inline-flex items-center justify-center rounded-xl border border-zinc-300 px-5 py-3 text-sm font-medium text-zinc-700 transition hover:border-zinc-500 hover:text-zinc-900">
                            Send to another email
                        </button>
                    </div>
                </div>

                @if (! $alreadyVerified)
                    <script>
                        const emailVerificationForm = document.getElementById('emailVerificationForm');
                        const emailField = document.getElementById('email');
                        const emailFormState = document.getElementById('emailFormState');
                        const emailSuccessState = document.getElementById('emailSuccessState');
                        const openEmailButton = document.getElementById('openEmailButton');
                        const emailSuccessMessage = document.getElementById('emailSuccessMessage');
                        const sendAnotherButton = document.getElementById('sendAnotherButton');
                        const emailErrorState = document.getElementById('emailErrorState');
                        const sendVerificationButton = document.getElementById('sendVerificationButton');
                        const csrfToken = '{{ csrf_token() }}';

                        emailVerificationForm.addEventListener('submit', async function (event) {
                            event.preventDefault();

                            if (!emailField.checkValidity()) {
                                emailField.reportValidity();
                                return;
                            }

                            const emailValue = emailField.value.trim();

                            emailErrorState.classList.add('hidden');
                            sendVerificationButton.disabled = true;
                            sendVerificationButton.textContent = 'Sending...';

                            try {
                                const response = await fetch("{{ route('verify.email.send') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({ email: emailValue })
                                });

                                const data = await response.json();

                                if (!response.ok) {
                                    throw new Error(data.message || 'Unable to send verification email right now.');
                                }

                                if (data.already_verified) {
                                    emailSuccessMessage.textContent = 'Your email is already verified. No additional verification is required.';
                                } else {
                                    emailSuccessMessage.textContent = `Success. The verification email has been sent to ${emailValue}.`;
                                }

                                openEmailButton.href = `mailto:${emailValue}`;
                                emailFormState.classList.add('hidden');
                                emailSuccessState.classList.remove('hidden');
                            } catch (error) {
                                emailErrorState.textContent = error.message || 'Unable to send verification email right now.';
                                emailErrorState.classList.remove('hidden');
                            } finally {
                                sendVerificationButton.disabled = false;
                                sendVerificationButton.textContent = 'Send Verification Email';
                            }
                        });

                        sendAnotherButton.addEventListener('click', function () {
                            emailSuccessState.classList.add('hidden');
                            emailFormState.classList.remove('hidden');
                            emailField.focus();
                        });
                    </script>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
