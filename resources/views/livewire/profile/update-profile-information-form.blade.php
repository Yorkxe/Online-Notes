<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    //for Image upload
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $Description = '';
    public $Image;
    /**
     * Mount the component.
     */
    
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->Description = Auth()->User()->Profile->Description;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(){
        $user = Auth::user();

        $info_user = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        if(!is_null($this->Image)){
            $info_Profile = $this->validate([
                'Description' => ['string', 'max:255'],
                'Image' => ['image', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
            ]);
        }else{
            $info_Profile = $this->validate([
                'Description' => ['string', 'max:255'],
            ]);
        }

        $user->fill($info_user);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->Image->storeAs(path:'public\Profiles', name: $user->id.'_'.date("Ymd", time()).'.jpg');

        if(!is_null($this->Image)){
            Auth()->User()->Profile()->update([
                'Description' => $info_Profile['Description'],
                'Image' => $user->id.'_'.date("Ymd", time()).'.jpg'
            ]);    
        }else{
            Auth()->User()->Profile()->update([
                'Description' => $info_Profile['Description'],
            ]);    
        }

        Auth()->User()->User_History()->create([
            'Move' => 'Update_Profiles',
            'Notes_id' => 0
        ]);

        $this->dispatch('profile-updated', name: $user->name);
        return redirect()->route('Profile.show', [$user]);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route(['Profile.show', $user], absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6" enctype="multipart/form-data">
        <div>
            <x-input-label for="name" :value="__('name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="Description" :value="__('Description')" />
            <x-text-input wire:model="Description" id="Description" name="Description" type="text" class="mt-1 block w-full" autofocus autocomplete="Description" />
            <x-input-error class="mt-2" :messages="$errors->get('Description')" />
        </div>

        <div>
            <x-input-label for="Image" :value="__('Image')" />
            <x-text-input wire:model="Image" id="Image" name="Image" type="file" class="mt-1 block w-full" accept="image/*"/>
            <x-input-error class="mt-2" :messages="$errors->get('Image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
