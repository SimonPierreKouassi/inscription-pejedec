@props([
    'padding' => 'md',
    'shadow' => 'md',
    'class' => ''
])

@php
$paddingClasses = [
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8'
];

$shadowClasses = [
    'sm' => 'shadow-sm',
    'md' => 'shadow-md',
    'lg' => 'shadow-lg'
];
@endphp

<div class="bg-white rounded-lg {{ $paddingClasses[$padding] }} {{ $shadowClasses[$shadow] }} {{ $class }}">
    {{ $slot }}
</div>