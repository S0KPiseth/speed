@extends('home.index')
@section('layoutContent')
<div class="min-h-screen bg-zinc-50">
    <x-nav-bar class="opacity-0"></x-nav-bar>

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

            <div class="mb-8">
                <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">Account verification</p>
                <h1 class="mt-2 text-3xl font-semibold text-zinc-900">ID Document Verification</h1>
                <p class="mt-3 text-sm text-zinc-600">Upload a valid identity document to verify account ownership and improve buyer trust.</p>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label for="document_type" class="mb-2 block text-sm font-medium text-zinc-700">Document Type</label>
                    <select id="document_type" name="document_type" class="w-full rounded-xl border border-zinc-200 px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-400">
                        <option value="">Select document type</option>
                        <option value="national_id">National ID</option>
                        <option value="passport">Passport</option>
                        <option value="driver_license">Driver License</option>
                    </select>
                </div>

                <div>
                    <label for="document_file" class="mb-2 block text-sm font-medium text-zinc-700">Upload Document</label>
                    <input id="document_file" name="document_file" type="file" accept="image/*,.pdf" class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-700 outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-zinc-900 file:px-3 file:py-2 file:text-sm file:text-white hover:file:bg-zinc-700">
                    <p class="mt-2 text-xs text-zinc-500">Accepted format: JPG, PNG, PDF. Max size: 10MB.</p>
                </div>

                <div class="pt-2 text-right">
                    <button type="submit" class="rounded-xl bg-zinc-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-zinc-700">Submit Document</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
