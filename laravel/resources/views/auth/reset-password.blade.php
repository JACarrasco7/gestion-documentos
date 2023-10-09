<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            {{-- <x-authentication-card-logo /> --}}
            <img src="/laravel/public/img/brand/vertical_logo.png" alt="{{ __('Area_contruccion_logo') }}"
            class="lg:max-w-[370px] xl:max-w-[500px] mx-auto" />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-input label="{{ __('Email') }}" id="email" class="block w-full mt-1" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-input label="{{ __('Password') }}" id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-input label="{{ __('Confirm Password') }}" id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button type="submit">
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
