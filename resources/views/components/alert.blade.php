{{-- resources/views/components/alert.blade.php --}}
@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
    'class' => ''
])

@php
$alertClasses = [
    'success' => 'bg-green-50 border-green-200 text-green-800',
    'error' => 'bg-red-50 border-red-200 text-red-800',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
    'info' => 'bg-orange-50 border-orange-200 text-orange-800'
];

$iconClasses = [
    'success' => 'text-green-400',
    'error' => 'text-red-400',
    'warning' => 'text-yellow-400',
    'info' => 'text-orange-400'
];

$icons = [
    'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
    'error' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
    'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
    'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
];
@endphp

<div class="rounded-md p-4 border {{ $alertClasses[$type] }} {{ $class }}" 
     @if($dismissible) x-data="{ show: true }" x-show="show" x-transition @endif> {{-- Added x-transition for smoothness --}}
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 {{ $iconClasses[$type] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$type] }}" />
            </svg>
        </div>
        <div class="ml-3 flex-1">
            @if($title)
                <h3 class="text-sm font-medium {{ $alertClasses[$type] }}">
                    {{ $title }}
                </h3>
            @endif
            <div class="text-sm {{ $title ? 'mt-1' : '' }}">
                {{ $slot }} {{-- <--- Use $slot here to render content passed into the component --}}
            </div>
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="show = false; $dispatch('dismiss')" {{-- Dispatch a 'dismiss' event --}}
                            class="inline-flex rounded-md p-1.5 hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>