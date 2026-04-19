<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $username = '';
    public string $phone = '';
    public $photo;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = (string) ($user->username ?? '');
        $this->phone = (string) ($user->phone ?? '');
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'username' => ['nullable', 'string', 'max:60', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($this->photo) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $validated['profile_photo_path'] = $this->photo->store('profile-photos', 'public');
        }

        $validated['username'] = $validated['username'] ?: null;
        $validated['phone'] = $validated['phone'] ?: null;

        unset($validated['photo']);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->reset('photo');

        $this->dispatch('profile-updated', name: $user->name, photoUrl: $user->profile_photo_url);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900">
            {{ __('profile.profile_information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('profile.profile_information_desc') }}
        </p>
    </header>

    <form wire:submit.prevent="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="photo" :value="__('profile.profile_photo')" />

            <div class="mt-2 flex items-center gap-4">
                <img
                    src="{{ $photo ? $photo->temporaryUrl() : auth()->user()->profile_photo_url }}"
                    alt="{{ auth()->user()->name }}"
                    class="h-16 w-16 rounded-full border border-slate-200 object-cover"
                >

                <div class="w-full">
                    <input wire:model="photo" id="photo" type="file" class="block w-full text-sm text-slate-600 file:me-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-slate-700">
                    <p class="mt-1 text-xs text-slate-500">{{ __('profile.profile_photo_hint') }}</p>
                </div>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('profile.name')" />
            <x-text-input wire:model="name" :value="$name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('profile.username')" />
            <x-text-input wire:model="username" :value="$username" id="username" name="username" type="text" class="mt-1 block w-full" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('profile.phone')" />
            <x-text-input wire:model="phone" :value="$phone" id="phone" name="phone" type="text" class="mt-1 block w-full" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('profile.email')" />
            <x-text-input wire:model="email" :value="$email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-slate-700">
                        {{ __('profile.email_unverified') }}

                        <button wire:click.prevent="sendVerification" class="rounded-md text-sm text-brand-primary underline hover:opacity-80 focus:outline-none">
                            {{ __('profile.resend_verification') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-emerald-600">
                            {{ __('profile.verification_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('profile.saved') }}
            </x-action-message>
        </div>
    </form>
</section>
