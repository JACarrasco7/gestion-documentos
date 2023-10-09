<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('/img/brand/vertical_logo.png') }}"
        type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @wireUiScripts

    <!-- Scripts -->
    @vite(['resources/css/app.css'])
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- @livewire('navigation') --}}
        @include('layouts.navigation')

        <div class="sm:p-4 md:ml-64">
            <!-- Page Heading -->
            <header class="sticky flex justify-between w-full bg-white rounded-md dark:bg-gray-800 top-5">
                <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar"
                    aria-controls="default-sidebar" type="button"
                    class="inline-flex items-center p-2 my-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>

                <div class="px-4 py-4 max-w-7xl md:px-6 lg:px-8">
                    {{ $header }}
                </div>
                <!-- Page Content -->
                <div class="px-4 mt-2 max-w-7xl md:px-6 lg:px-8">

                    {{-- <button type="button" data-dropdown-toggle="language-dropdown"
                        class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:hover:text-white dark:text-gray-400 hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <img src="https://grupoargenia.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                            class="w-5 {{ app()->getLocale() == 'en' ? 'hidden' : '' }}" alt="">

                        <img src="https://grupoargenia.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                            class="w-5 {{ app()->getLocale() == 'es' ? 'hidden' : '' }}" alt="">
                    </button> --}}
                    <!-- Dropdown -->
                    {{-- <div class="absolute z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700"
                        id="language-dropdown">
                        <ul class="py-1" role="none">
                            <li>
                                <a href="{{ route('locale.setting', 'en') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-300 dark:hover:bg-gray-600"
                                    role="menuitem">
                                    <div class="inline-flex items-center">
                                        <img src="https://grupoargenia.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/en.png"
                                            class="w-5 mr-2" alt="">
                                        {{ __('English (UK)') }}
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('locale.setting', 'es') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-600"
                                    role="menuitem">
                                    <div class="inline-flex items-center">
                                        <img src="https://grupoargenia.com/wp-content/plugins/sitepress-multilingual-cms/res/flags/es.png"
                                            class="w-5 mr-2" alt="">
                                        {{ __('Spanish') }}
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div> --}}

                    <button id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">

                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                </div>
            </header>

            <div class="p-4">
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
        @vite(['resources/js/app.js'])

        @livewireScripts
        @stack('modals')
        @livewire('livewire-ui-modal')
        @stack('js')
</body>

</html>
