@props([
    'variant' => 'full',
    'href' => null,
])

@php
    $variantClasses = match ($variant) {
        'icon' => 'h-10 w-auto',
        'compact' => 'h-14 w-auto',
        default => 'h-28 w-auto',
    };

@endphp

@if ($href)
    <a href="{{ $href }}" class="inline-flex items-center justify-center" aria-label="SERVANA">
        <img
            src="{{ asset('images/logo/servana-logo.png') }}"
            alt="Logo SERVANA"
            loading="eager"
            {{ $attributes->class([$variantClasses, 'max-w-full object-contain']) }}
        >
    </a>
@else
    <img
        src="{{ asset('images/logo/servana-logo.png') }}"
        alt="Logo SERVANA"
        loading="eager"
        {{ $attributes->class([$variantClasses, 'max-w-full object-contain']) }}
    >
@endif
