<div>

    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $insert ? __('Create') : __('Edit') }} {{ __('user') }}
                </h3>
                <button wire:click="$emit('closeModal')"
                    class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="staticModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6">
                <div class="grid gap-4 md:grid-cols-2">
                    <x-input wire:model="state.name" label="{{ __('Name') }}" id="name" name="name"
                        placeholder="{{ __('Enter name') }}" required autocomplete="name" />

                    <x-select wire:model="selectRole_user" label="Rol" placeholder="{{ __('Select role') }}"
                        :options="Helpers::getRolesName()" id="selectRole_user" name="selectRole_user" option-label="name"
                        option-value="id" />

                    <x-input wire:model="state.username" label="{{ __('Username') }}" id="username" name="username"
                        placeholder="{{ __('Enter username') }}" required autocomplete="username" />
                    <x-input wire:model="state.email" label="{{ __('Email') }}" id="email" name="email"
                        placeholder="{{ __('Enter email') }}" required autocomplete="email" />

                    <x-input wire:model="state.password" type="password" label="{{ __('Password') }}" id="password"
                        name="password" placeholder="{{ __('Enter password') }}" required autocomplete="password" />
                    <x-input wire:model="state.password_confirmation" type="password"
                        label="{{ __('Password confirmation') }}" id="password_confirmation"
                        name="password_confirmation" placeholder="{{ __('Enter password confirmation') }}" required
                        autocomplete="password_confirmation" />
                    {{-- Only if role is company --}}
                    @if ($selectRole_user === 2)
                        {{-- Companies --}}
                        <x-select wire:model.defer="company_id" label="{{ __('Select company') }}"
                            placeholder="{{ __('Select company') }}" :async-data="route('search.companies')" option-label="name"
                            option-value="id" />
                    @endif
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <x-modal-footer wireClick="saveUser"></x-modal-footer>
            </div>
        </div>
    </div>

</div>
