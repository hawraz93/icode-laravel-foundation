<?php

$locales = array_values(array_filter(array_map(
    static fn (string $locale): string => trim($locale),
    explode(',', (string) env('BRAND_LOCALES', 'en,ku,ar'))
)));

if ($locales === []) {
    $locales = ['en'];
}

$navigationLayout = (string) env('BRAND_NAV_LAYOUT', 'topbar');
if (! in_array($navigationLayout, ['topbar', 'sidebar'], true)) {
    $navigationLayout = 'topbar';
}

$sidebarDensity = (string) env('BRAND_SIDEBAR_DENSITY', 'normal');
if (! in_array($sidebarDensity, ['normal', 'compact'], true)) {
    $sidebarDensity = 'normal';
}

return [
    'name' => env('BRAND_NAME', config('app.name', 'SmartExam Organizer')),
    'tagline' => env('BRAND_TAGLINE', 'Reusable auth-first Laravel base for fast project launches.'),
    'logo_path' => env('BRAND_LOGO_PATH', 'images/logo.svg'),

    'colors' => [
        'primary' => env('BRAND_COLOR_PRIMARY', '#0f766e'),
        'secondary' => env('BRAND_COLOR_SECONDARY', '#0ea5e9'),
        'accent' => env('BRAND_COLOR_ACCENT', '#f97316'),
        'surface' => env('BRAND_COLOR_SURFACE', '#f8fafc'),
        'surface_dark' => env('BRAND_COLOR_SURFACE_DARK', '#0f172a'),
        'text' => env('BRAND_COLOR_TEXT', '#0f172a'),
    ],

    'support' => [
        'company' => env('SUPPORT_COMPANY', 'I-CODE Group'),
        'website' => env('SUPPORT_WEBSITE', 'https://icodegroup.net/'),
        'email' => env('SUPPORT_EMAIL', 'info@icodegroup.net'),
        'facebook' => env('SUPPORT_FACEBOOK', 'https://facebook.com/icodegroup'),
        'whatsapp' => env('SUPPORT_WHATSAPP', 'https://wa.me/9647700941717'),
        'telegram' => env('SUPPORT_TELEGRAM', 'https://t.me/icodegroup'),
        'whatsapp_text' => env('SUPPORT_WHATSAPP_TEXT', '+9647700941717'),
        'telegram_text' => env('SUPPORT_TELEGRAM_TEXT', '@icodegroup'),
        'facebook_text' => env('SUPPORT_FACEBOOK_TEXT', '/icodegroup'),
    ],

    'locales' => $locales,
    'navigation_layout' => $navigationLayout,
    'sidebar_density' => $sidebarDensity,
];
