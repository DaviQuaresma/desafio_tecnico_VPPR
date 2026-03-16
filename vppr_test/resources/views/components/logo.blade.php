@props(['class' => 'h-8', 'variant' => 'dark'])
@php
    $textColor = $variant === 'light' ? '#ffffff' : '#0f1729';
    $accentColor = '#d4a636';
@endphp
<svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
    <text x="0" y="28" font-family="Inter, Arial, sans-serif" font-size="24" font-weight="700" fill="{{ $textColor }}">VPPR</text>
    <rect x="82" y="4" width="12" height="12" fill="{{ $accentColor }}"/>
    <text x="0" y="38" font-family="Inter, Arial, sans-serif" font-size="6" font-weight="400" fill="{{ $textColor }}" opacity="0.7">CONSULTORIA JURÍDICA</text>
</svg>
