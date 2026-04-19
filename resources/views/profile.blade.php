<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-800">
            {{ __('profile.title') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="card-surface">
                <div class="max-w-2xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="card-surface">
                <div class="max-w-2xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="card-surface">
                <div class="max-w-2xl">
                    <livewire:profile.two-factor-authentication-form />
                </div>
            </div>

            <div class="card-surface">
                <div class="max-w-3xl">
                    <livewire:profile.browser-sessions-form />
                </div>
            </div>

            <div class="card-surface">
                <div class="max-w-2xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
