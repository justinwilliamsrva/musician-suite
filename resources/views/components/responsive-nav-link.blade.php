@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-1 text-left text-sm font-medium text-white transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-1 text-left text-sm font-medium text-white opacity-80 hover:opacity-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
