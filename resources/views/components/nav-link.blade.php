@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-amber-600 border-b-2 border-amber-600 font-semibold'
            : 'text-gray-600 hover:text-amber-600 hover:border-b-2 hover:border-amber-600 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes . ' px-3 py-2 text-base']) }}>
    {{ $slot }}
</a>
