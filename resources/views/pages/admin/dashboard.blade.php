@extends('home.index')

@section('layoutContent')
<div class="min-h-screen bg-zinc-50">
    <x-nav-bar class="opacity-0"></x-nav-bar>

    <div class="mx-auto w-full px-4 py-10">
        <div class="mb-8 rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">Admin Panel</p>
            <h1 class="mt-2 text-3xl font-semibold text-zinc-900">ID Approval Dashboard</h1>
            <p class="mt-3 max-w-2xl text-sm text-zinc-600">Review pending identity submissions and approve verified users. Approved users are promoted to seller role automatically.</p>
        </div>

        @if (session('success'))
            <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif

        @if ($pendingRequests->isEmpty())
            <div class="rounded-3xl border border-zinc-200 bg-white p-10 text-center shadow-sm">
                <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">Queue</p>
                <h2 class="mt-2 text-2xl font-semibold text-zinc-900">No pending ID requests</h2>
                <p class="mt-3 text-sm text-zinc-600">All submitted IDs are already processed.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-5">
                @foreach ($pendingRequests as $item)
                    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
                        <div class="mb-4 flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.16em] text-zinc-500">Pending Request</p>
                                <h3 class="mt-1 text-xl font-semibold text-zinc-900">{{ $item->username }}</h3>
                                <p class="text-sm text-zinc-600">{{ $item->email }}</p>
                                <p class="mt-1 text-xs text-zinc-500">Submitted {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-medium uppercase tracking-[0.12em] text-amber-700">Pending</span>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 w-fit">
                            <a href="{{ $item->id_front_url }}" target="_blank" rel="noopener" class="group block overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-100">
                                <img src="{{ $item->id_front_url }}" alt="Front ID image" class="h-52 aspect-[1.586/1] object-cover transition duration-300 group-hover:scale-[1.02]">
                                <div class="border-t border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600">Front side</div>
                            </a>
                            <a href="{{ $item->id_back_url }}" target="_blank" rel="noopener" class="group block overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-100">
                                <img src="{{ $item->id_back_url }}" alt="Back ID image" class="h-52 aspect-[1.586/1] object-cover transition duration-300 group-hover:scale-[1.02]">
                                <div class="border-t border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-600">Back side</div>
                            </a>
                        </div>

                        <div class="mt-5 flex flex-wrap items-center justify-end gap-3">
                            <form action="{{ route('admin.id.approve', ['requestId' => $item->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-xl bg-zinc-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-700">
                                    Approve ID
                                </button>
                            </form>

                            <button
                                type="button"
                                data-reject-toggle="{{ $item->id }}"
                                class="rounded-xl border border-rose-300 bg-white px-5 py-2.5 text-sm font-medium text-rose-700 transition hover:bg-rose-50"
                            >
                                Reject
                            </button>
                        </div>

                        <form
                            action="{{ route('admin.id.reject', ['requestId' => $item->id]) }}"
                            method="POST"
                            data-reject-form="{{ $item->id }}"
                            class="mt-4 hidden rounded-2xl border border-zinc-200 bg-zinc-50 p-4"
                        >
                            @csrf
                            <label for="rejection_reason_{{ $item->id }}" class="mb-2 block text-sm font-medium text-zinc-700">Reason for rejection</label>
                            <textarea
                                id="rejection_reason_{{ $item->id }}"
                                name="rejection_reason"
                                rows="3"
                                required
                                minlength="5"
                                maxlength="500"
                                class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-800 outline-none transition focus:border-zinc-500"
                                placeholder="Write a clear reason so the user can correct and resubmit."
                            >{{ old('rejection_reason') }}</textarea>
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700">
                                    Confirm Reject
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    (() => {
        const toggleButtons = document.querySelectorAll('[data-reject-toggle]');

        toggleButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const requestId = button.getAttribute('data-reject-toggle');
                const form = document.querySelector(`[data-reject-form="${requestId}"]`);

                if (!form) {
                    return;
                }

                form.classList.toggle('hidden');

                if (!form.classList.contains('hidden')) {
                    const input = form.querySelector('textarea[name="rejection_reason"]');
                    if (input) {
                        input.focus();
                    }
                }
            });
        });
    })();
</script>
@endsection
