@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
    'href' => null,
    'class' => ''
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2';

$variantClasses = [
    'primary' => 'bg-orange-600 text-white hover:bg-orange-700 focus:ring-orange-500 disabled:bg-orange-300',
    'secondary' => 'bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-gray-500 disabled:bg-gray-100',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 disabled:bg-red-300',
    'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500 disabled:bg-green-300'
];

$sizeClasses = [
    'sm' => 'px-3 py-1.5 text-sm',
    'md' => 'px-4 py-2 text-base',
    'lg' => 'px-6 py-3 text-lg'
];

$isDisabled = $disabled || $loading;
$classes = "{$baseClasses} {$variantClasses[$variant]} {$sizeClasses[$size]} {$class}";

if ($isDisabled) {
    $classes .= ' cursor-not-allowed';
} else {
    $classes .= ' cursor-pointer';
}
@endphp

@if($href)
    <a {{ $attributes }} href="{{ $href }}" class="{{ $classes }}">
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes }} type="{{ $type }}" 
            @if($isDisabled) disabled @endif
            class="{{ $classes }}">
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif
        {{ $slot }}
    </button>
@endif