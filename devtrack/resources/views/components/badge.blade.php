@props(['type' => 'info'])

@php
    $typeClasses = [
        'success' => 'bg-emerald-100 text-emerald-800',
        'danger' => 'bg-red-100 text-red-800',
        'warning' => 'bg-amber-100 text-amber-800',
        'info' => 'bg-indigo-100 text-indigo-800',
        'secondary' => 'bg-gray-100 text-gray-800',
    ];
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold gap-1 ' . $classes]) }}>
    {{ $leading ?? '' }}
    {{ $slot }}
</span>
