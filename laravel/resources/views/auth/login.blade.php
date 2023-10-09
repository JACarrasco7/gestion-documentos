<x-guest-layout>
    <div class="flex min-h-screen">
        <div
            class="bg-gradient-to-b to-[#fffffffc] from-[#e21c2376] w-1/2  min-h-screen hidden lg:flex flex-col items-center justify-center text-white dark:text-black p-4">
            <div class="w-full mx-auto mb-5"><img src="./laravel/public/img/brand/vertical_logo.png" alt="{{ __('Area_contruccion_logo') }}"
                    class="lg:max-w-[370px] xl:max-w-[500px] mx-auto" /></div>
        </div>
        <div class="relative flex items-center justify-center w-full dark:bg-slate-700 lg:w-1/2">
            <div class="max-w-[480px] w-full  p-5 md:p-10">
                <h2 class="mb-3 text-3xl font-bold">{{ __('Documentary area') }}</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input label="{{ __('Username') }}" id="username" class="block w-full mt-1" name="username"
                            :value="old('username')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-input label="{{ __('Password') }}" id="password" class="block w-full mt-1" type="password"
                            name="password" required autocomplete="current-password" />
                    </div>

                    {{-- <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div> --}}

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button type="submit" class="ml-4 bg-[#e21c239c] dark:bg-red-500 dark:text-white  hover:bg-[#e45459] dark:hover:bg-red-700 text-white">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
