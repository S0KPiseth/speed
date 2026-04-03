@extends('home.index')
@section('layoutContent')
@php
    $currentStatus = ($idVerificationStatus ?? null);
    $isPending = ($currentStatus === 'pending');
    $isApproved = ($currentStatus === 'approved');
    $isRejected = ($currentStatus === 'rejected');
    $showPendingSuccess = Session::has('success') || $isPending;
    $errorMessage = $errors->first();
@endphp
<div class="min-h-screen bg-zinc-50">
    <x-nav-bar class="opacity-0"></x-nav-bar>

    @if ($errorMessage)
        <div class="fixed top-15 right-4 z-[9999] flex flex-col gap-y-1.5 pointer-events-none">
            <div class="pointer-events-auto">
                <x-feedback-log :error="$errorMessage"></x-feedback-log>
            </div>
        </div>
    @endif

    <div class="mx-auto flex w-full max-w-3xl items-center justify-center px-4 py-12">
        <div class="w-full rounded-3xl border border-zinc-200 bg-white p-8 shadow-sm">
            <div class="mb-6">
                <a href="{{ route('verify') }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-800">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M15 6 9 12l6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Back to verification options
                </a>
            </div>

            @if ($isApproved)
                <div class="text-center">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Verified</p>
                    <h2 class="mt-2 text-3xl font-semibold text-zinc-900">You Are Already Verified</h2>
                    <p class="mt-3 text-sm text-zinc-600">Your ID verification has been approved by our team.</p>
                    <div class="mt-7">
                        <a href="{{ route('verify') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">
                            Return to Verification Page
                        </a>
                    </div>
                </div>
            @elseif ($showPendingSuccess)
                <div class="text-center">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Success</p>
                    <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Document Uploaded</h2>
                    <p class="mt-3 text-sm text-zinc-600">Your document is successfully uploaded and waiting for our team to verify.</p>
                    <div class="mt-7">
                        <a href="{{ route('verify') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">
                            Return to Verification Page
                        </a>
                    </div>
                </div>
            @elseif ($isRejected)
                <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-rose-600">Rejected</p>
                    <h2 class="mt-2 text-2xl font-semibold text-zinc-900">Your Verification Was Rejected</h2>
                    <p class="mt-3 text-sm text-zinc-700">Reason: {{ $idVerificationReason ?? 'No reason provided.' }}</p>
                </div>


                <div id="upload-again" class="mt-8">
                    <div class="mb-8">
                        <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">Account verification</p>
                        <h1 class="mt-2 text-3xl font-semibold text-zinc-900">Re-Upload ID Document</h1>
                        <p class="mt-3 text-sm text-zinc-600">Please upload clear front and back images of your ID and correct the issues mentioned in the rejection reason.</p>
                    </div>

                    <form id="documentVerificationForm" action="{{ route('verify.document.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="id_front" class="mb-2 block text-sm font-medium text-zinc-700">ID Front Side</label>
                                <label for="id_front" data-upload-box="id_front" class="group relative flex h-44 w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-zinc-300 bg-zinc-50 px-4 text-center transition hover:border-zinc-500 hover:bg-zinc-100">
                                    <img data-upload-preview="id_front" alt="Front ID preview" class="absolute inset-0 hidden h-full w-full object-cover">
                                    <div data-upload-empty="id_front" class="relative z-10">
                                        <span class="text-sm font-medium text-zinc-700">Upload front image</span>
                                        <span class="mt-1 block text-xs text-zinc-500">JPG, PNG (max 10MB)</span>
                                    </div>
                                    <button data-upload-remove="id_front" type="button" class="absolute right-2 top-2 z-20 hidden h-8 w-8 items-center justify-center rounded-full bg-white/95 text-lg font-semibold text-zinc-700 shadow transition hover:bg-white">&times;</button>
                                    <input id="id_front" name="id_front" type="file" accept="image/jpeg,image/png" class="hidden">
                                </label>
                            </div>

                            <div>
                                <label for="id_back" class="mb-2 block text-sm font-medium text-zinc-700">ID Back Side</label>
                                <label for="id_back" data-upload-box="id_back" class="group relative flex h-44 w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-zinc-300 bg-zinc-50 px-4 text-center transition hover:border-zinc-500 hover:bg-zinc-100">
                                    <img data-upload-preview="id_back" alt="Back ID preview" class="absolute inset-0 hidden h-full w-full object-cover">
                                    <div data-upload-empty="id_back" class="relative z-10">
                                        <span class="text-sm font-medium text-zinc-700">Upload back image</span>
                                        <span class="mt-1 block text-xs text-zinc-500">JPG, PNG (max 10MB)</span>
                                    </div>
                                    <button data-upload-remove="id_back" type="button" class="absolute right-2 top-2 z-20 hidden h-8 w-8 items-center justify-center rounded-full bg-white/95 text-lg font-semibold text-zinc-700 shadow transition hover:bg-white">&times;</button>
                                    <input id="id_back" name="id_back" type="file" accept="image/jpeg,image/png" class="hidden">
                                </label>
                            </div>
                        </div>

                        <div class="pt-2 text-right">
                            <button id="documentSubmitButton" type="submit" class="rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">Submit ID Verification</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="mb-8">
                    <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">Account verification</p>
                    <h1 class="mt-2 text-3xl font-semibold text-zinc-900">ID Document Verification</h1>
                    <p class="mt-3 text-sm text-zinc-600">Upload the front and back sides of your national ID to verify account ownership and improve buyer trust.</p>
                </div>

                <form id="documentVerificationForm" action="{{ route('verify.document.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label for="id_front" class="mb-2 block text-sm font-medium text-zinc-700">ID Front Side</label>
                            <label for="id_front" data-upload-box="id_front" class="group relative flex h-44 w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-zinc-300 bg-zinc-50 px-4 text-center transition hover:border-zinc-500 hover:bg-zinc-100">
                                <img data-upload-preview="id_front" alt="Front ID preview" class="absolute inset-0 hidden h-full w-full object-cover">
                                <div data-upload-empty="id_front" class="relative z-10">
                                    <span class="text-sm font-medium text-zinc-700">Upload front image</span>
                                    <span class="mt-1 block text-xs text-zinc-500">JPG, PNG (max 10MB)</span>
                                </div>
                                <button data-upload-remove="id_front" type="button" class="absolute right-2 top-2 z-20 hidden h-8 w-8 items-center justify-center rounded-full bg-white/95 text-lg font-semibold text-zinc-700 shadow transition hover:bg-white">&times;</button>
                                <input id="id_front" name="id_front" type="file" accept="image/jpeg,image/png" class="hidden">
                            </label>
                        </div>

                        <div>
                            <label for="id_back" class="mb-2 block text-sm font-medium text-zinc-700">ID Back Side</label>
                            <label for="id_back" data-upload-box="id_back" class="group relative flex h-44 w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-zinc-300 bg-zinc-50 px-4 text-center transition hover:border-zinc-500 hover:bg-zinc-100">
                                <img data-upload-preview="id_back" alt="Back ID preview" class="absolute inset-0 hidden h-full w-full object-cover">
                                <div data-upload-empty="id_back" class="relative z-10">
                                    <span class="text-sm font-medium text-zinc-700">Upload back image</span>
                                    <span class="mt-1 block text-xs text-zinc-500">JPG, PNG (max 10MB)</span>
                                </div>
                                <button data-upload-remove="id_back" type="button" class="absolute right-2 top-2 z-20 hidden h-8 w-8 items-center justify-center rounded-full bg-white/95 text-lg font-semibold text-zinc-700 shadow transition hover:bg-white">&times;</button>
                                <input id="id_back" name="id_back" type="file" accept="image/jpeg,image/png" class="hidden">
                            </label>
                        </div>
                    </div>

                    <div class="pt-2 text-right">
                        <button id="documentSubmitButton" type="submit" class="rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">Submit ID Verification</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@if (! $isApproved && ! $showPendingSuccess)
    <script>
        (() => {
            const configureUploadPreview = (fieldName) => {
                const input = document.getElementById(fieldName);
                const preview = document.querySelector(`[data-upload-preview="${fieldName}"]`);
                const emptyState = document.querySelector(`[data-upload-empty="${fieldName}"]`);
                const removeButton = document.querySelector(`[data-upload-remove="${fieldName}"]`);

                if (!input || !preview || !emptyState || !removeButton) {
                    return;
                }

                const clearPreview = () => {
                    input.value = '';
                    preview.src = '';
                    preview.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    removeButton.classList.add('hidden');
                };

                input.addEventListener('change', (event) => {
                    const file = event.target.files && event.target.files[0] ? event.target.files[0] : null;

                    if (!file) {
                        clearPreview();
                        return;
                    }

                    const objectUrl = URL.createObjectURL(file);
                    preview.src = objectUrl;
                    preview.onload = () => URL.revokeObjectURL(objectUrl);
                    preview.classList.remove('hidden');
                    emptyState.classList.add('hidden');
                    removeButton.classList.remove('hidden');
                });

                removeButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    clearPreview();
                });
            };

            const form = document.getElementById('documentVerificationForm');
            const submitButton = document.getElementById('documentSubmitButton');

            if (form && submitButton) {
                form.addEventListener('submit', () => {
                    submitButton.disabled = true;
                    submitButton.classList.add('cursor-not-allowed', 'opacity-70');
                    submitButton.textContent = 'Uploading...';
                });
            }

            configureUploadPreview('id_front');
            configureUploadPreview('id_back');
        })();
    </script>
@endif
@endsection
