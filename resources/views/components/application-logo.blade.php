@php
    $logoPath = config('branding.logo_path', 'images/logo.svg');
    $logoUrl = asset($logoPath);
@endphp

<img src="{{ $logoUrl }}" alt="{{ config('branding.name') }}" {{ $attributes }}>
