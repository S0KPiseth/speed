@props([
    'title',
    'subtitle',
    'disabled' => false,
    'verified' => false,
    'pending' => false,
    'rejected' => false,
    'href' => null,
])

@php
    $baseClasses = 'group flex flex-col items-center justify-start text-center rounded-2xl p-4 w-44 h-44 shadow-sm transition';
    $stateClasses = $disabled
        ? 'border border-emerald-300 bg-emerald-50 cursor-not-allowed'
        : ($rejected
            ? 'border border-rose-300 bg-rose-50 hover:border-rose-500 hover:shadow-md'
            : ($pending
                ? 'border border-amber-300 bg-amber-50 hover:border-amber-500 hover:shadow-md'
                : ($verified
                    ? 'border border-emerald-300 bg-emerald-50 hover:border-emerald-500 hover:shadow-md'
                    : 'border border-zinc-300 bg-white hover:border-zinc-900 hover:shadow-md')));
@endphp

@if ($href && ! $disabled)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $stateClasses]) }}>
@else
<button type="button" @disabled($disabled) {{ $attributes->merge(['class' => $baseClasses . ' ' . $stateClasses]) }}>
@endif
    <span class="flex h-12 w-12 items-center justify-center rounded-xl transition {{ $disabled ? 'bg-emerald-100 text-emerald-700' : ($rejected ? 'bg-rose-100 text-rose-700 group-hover:bg-rose-200' : ($pending ? 'bg-amber-100 text-amber-700 group-hover:bg-amber-200' : ($verified ? 'bg-emerald-100 text-emerald-700 group-hover:bg-emerald-200' : 'bg-zinc-100 text-zinc-700 group-hover:bg-zinc-900 group-hover:text-white'))) }}">
        {{ $icon }}
    </span>
    <span class="mt-4 text-sm font-semibold text-zinc-900 leading-tight">{{ $title }}</span>
    <span class="mt-2 text-xs text-zinc-500 leading-relaxed">{{ $subtitle }}</span>
    @if ($verified)
        <span class="mt-3 inline-flex items-center rounded-full bg-emerald-100 px-2 py-1 text-[11px] font-medium text-emerald-700">
            Already verified
        </span>
    @elseif ($rejected)
        <span class="mt-3 inline-flex items-center rounded-full bg-rose-100 px-2 py-1 text-[11px] font-medium text-rose-700">
            Rejected
        </span>
    @elseif ($pending)
        <span class="mt-3 inline-flex items-center rounded-full bg-amber-100 px-2 py-1 text-[11px] font-medium text-amber-700">
            Pending
        </span>
    @endif
@if ($href && ! $disabled)
</a>
@else
</button>
@endif
