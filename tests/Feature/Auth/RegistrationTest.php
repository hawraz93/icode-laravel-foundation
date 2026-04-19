<?php

namespace Tests\Feature\Auth;

use Livewire\Volt\Volt;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response
        ->assertOk()
        ->assertSeeVolt('pages.auth.register');
});

test('new users can register', function () {
    $component = Volt::test('pages.auth.register')
        ->set('name', 'Test User')
        ->set('username', 'test_user')
        ->set('phone', '+9647700000000')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password');

    $component->call('register');

    $component->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('username and phone must be unique on registration', function () {
    \App\Models\User::factory()->create([
        'username' => 'existing_user',
        'phone' => '+9647711111111',
    ]);

    $component = Volt::test('pages.auth.register')
        ->set('name', 'Another User')
        ->set('username', 'existing_user')
        ->set('phone', '+9647711111111')
        ->set('email', 'another@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password');

    $component->call('register');

    $component->assertHasErrors(['username', 'phone']);
    $this->assertGuest();
});
