@props([
    'permission', // e.g. 'appearance.manage'
    'fallback' => false, // show fallback slot or nothing
])
@php
$user = auth()->user();
$allowed = $user && $user->can($permission);
@endphp
@if($allowed)
    {{ $slot }}
@elseif($fallback && isset($fallback))
    {{ $fallback }}
@endif
