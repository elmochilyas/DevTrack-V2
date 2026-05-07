@props(['type' => 'success', 'dismissible' => false])

@php
    $typeClasses = [
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        'info' => 'bg-indigo-50 border-indigo-200 text-indigo-800',
    ];
    $classes = $typeClasses[$type] ?? $typeClasses['success'];
@endphp

<div {{ $attributes->merge(['class' => 'border-l-4 p-4 rounded-r-xl ' . $classes, 'role' => 'alert']) }}>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <span class="font-medium">{{ $slot }}</span>
        </div>
        @if($dismissible)
            <button type="button" class="ml-4 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full p-1" aria-label="Dismiss alert">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
</div>
