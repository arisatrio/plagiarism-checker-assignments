@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-white text-md font-bold leading-5 text-white focus:outline-none focus:border-white transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-md font-medium leading-5' . '" style="color: #a0aec0;"';
@endphp

@if($active ?? false)
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <a {{ $attributes->merge(['class' => $classes . ' nav-link-muted']) }} style="color: #bfc8d8;">
        {{ $slot }}
    </a>
@endif
@once
    <style>
        .nav-link-muted { color: #bfc8cf !important; }
    </style>
@endonce
