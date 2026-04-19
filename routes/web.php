<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::view('/', 'welcome');

Route::get('/locale/{locale}', function (string $locale, Request $request) {
    $supported = config('branding.locales', ['en']);

    if (in_array($locale, $supported, true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('locale.switch');

Route::get('/ui/sidebar-density/{density}', function (string $density) {
    if (in_array($density, ['normal', 'compact'], true)) {
        session(['sidebar_density' => $density]);
    }

    return redirect()->back();
})->middleware('auth')->name('ui.sidebar-density');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'auth.session'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth', 'auth.session'])
    ->name('profile');

Route::middleware(['auth', 'verified', 'auth.session'])->prefix('demo')->name('demo.')->group(function () {
    Route::view('calendar', 'demo.section', [
        'title' => 'Exam Calendar',
        'description' => 'Sample page for sidebar menu testing.',
        'content' => 'This page is connected directly to a sidebar menu item so you can verify active states and responsive behavior.',
        'badge' => 'Menu Item',
    ])->name('calendar');

    Route::view('halls', 'demo.section', [
        'title' => 'Halls Management',
        'description' => 'Sample hall management page.',
        'content' => 'Use this page to test simple menu navigation and layout spacing on mobile and iPad.',
        'badge' => 'Menu Item',
    ])->name('halls');

    Route::view('invigilators', 'demo.section', [
        'title' => 'Invigilators',
        'description' => 'Sample invigilators page.',
        'content' => 'This route helps test standard sidebar item rendering in all breakpoints.',
        'badge' => 'Menu Item',
    ])->name('invigilators');

    Route::view('planning/midterm', 'demo.section', [
        'title' => 'Midterm Plan',
        'description' => 'Nested submenu example.',
        'content' => 'This is a nested submenu route (level 2). You should see parent menu and child submenu opened and active.',
        'badge' => 'Submenu',
    ])->name('planning.midterm');

    Route::view('planning/final', 'demo.section', [
        'title' => 'Final Plan',
        'description' => 'Nested submenu example.',
        'content' => 'This is another nested submenu route for final planning.',
        'badge' => 'Submenu',
    ])->name('planning.final');

    Route::view('reports/daily', 'demo.section', [
        'title' => 'Daily Reports',
        'description' => 'Reports submenu route.',
        'content' => 'Daily reports test page linked from sidebar submenu.',
        'badge' => 'Submenu',
    ])->name('reports.daily');

    Route::view('reports/summary', 'demo.section', [
        'title' => 'Summary Reports',
        'description' => 'Reports submenu route.',
        'content' => 'Summary reports test page linked from sidebar submenu.',
        'badge' => 'Submenu',
    ])->name('reports.summary');

    Route::middleware('can:view users')->group(function () {
        Route::view('users/list', 'demo.section', [
            'title' => 'Users List',
            'description' => 'Permission-gated route sample.',
            'content' => 'Use this page when testing Spatie permission-based menu visibility.',
            'badge' => 'Permission',
        ])->name('users.list');
    });

    Route::middleware('can:manage roles')->group(function () {
        Route::view('roles/permissions', 'demo.section', [
            'title' => 'Roles & Permissions',
            'description' => 'Permission-gated route sample.',
            'content' => 'This page is intended for admin role / manage roles permission checks.',
            'badge' => 'Permission',
        ])->name('roles.permissions');
    });
});

require __DIR__.'/auth.php';
