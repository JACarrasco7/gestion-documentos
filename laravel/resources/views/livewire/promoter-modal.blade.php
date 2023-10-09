<div>

    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $insert ? __('Create') : __('Edit') }} {{ __('Promoter') }}
                </h3>
                <button wire:click="$emit('closeModal')"
                    class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="staticModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="grid gap-4 p-6 lg:grid-cols-2">

                <div class="space-y-4">
                    <div class="grid gap-2 md:grid-cols-2">
                        {{-- Name --}}
                        <x-input wire:model="state.name" label="{{ __('Name') }}" id="name" name="name"
                            placeholder="{{ __('Enter name') }}" required autocomplete="name" />

                        {{-- Email --}}
                        <x-input wire:model="state.email" label="{{ __('Email') }}" id="email" name="email"
                            placeholder="{{ __('Enter email') }}" required autocomplete="email" />
                    </div>

                    {{-- Phones --}}
                    <div class="grid gap-2 md:grid-cols-2">
                        <x-input pattern="[0-9]" wire:model="state.phone_1" label="{{ __('Phone') }} 1" id="phone_1"
                            name="phone_1" placeholder="{{ __('Enter phone') }}" required autocomplete="phone_1"
                            onKeyPress="if(this.value.length==9) return false;" />

                        <x-input pattern="[0-9]" wire:model="state.phone_2" label="{{ __('Phone') }} 2" id="phone_2"
                            name="phone_2" placeholder="{{ __('Enter phone') }}" required autocomplete="phone_2"
                            onKeyPress="if(this.value.length==9) return false;" />
                    </div>


                    <div class="grid gap-2 md:grid-cols-2">
                        {{-- Province --}}
                        <x-input wire:model="state.province" label="{{ __('Province') }}" id="province"
                            name="province" placeholder="{{ __('Enter province') }}" required
                            autocomplete="province" />

                        {{-- City --}}
                        <x-input class="col-span-3" wire:model="state.city" label="{{ __('City') }}" id="city"
                            name="city" placeholder="{{ __('Enter city') }}" required autocomplete="city" />
                    </div>

                    <div class="grid gap-2 md:grid-cols-7">
                        {{-- Postal code --}}
                        <div class="md:col-span-2">
                            <x-input wire:model="state.postal_code" label="{{ __('Postal code') }}" id="postal_code"
                                name="postal_code" placeholder="{{ __('Enter postal code') }}" required
                                autocomplete="postal_code" />
                        </div>
                        {{-- Address --}}
                        <div class="md:col-span-5">
                            <x-input wire:model="state.address" label="{{ __('Address') }}" id="address"
                                name="address" placeholder="{{ __('Enter address') }}" required
                                autocomplete="address" />
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Contact 1 -->
                    <div
                        class="block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <p class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">{{ __('Contact') }} 1
                        </p>
                        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="grid grid-cols-2 gap-2">
                            {{-- Name --}}
                            <x-input wire:model="state.contact_name_1" label="{{ __('Name') }}" id="name"
                                name="name" placeholder="{{ __('Enter name') }}" required autocomplete="name" />

                            {{-- Email --}}
                            <x-input wire:model="state.contact_email_1" label="{{ __('Email') }}" id="email"
                                name="email" placeholder="{{ __('Enter email') }}" required
                                autocomplete="email" />
                        </div>
                    </div>

                    <!-- Contact 2 -->
                    <div
                        class="block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <p class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">{{ __('Contact') }}
                            2</p>
                        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="grid grid-cols-2 gap-2">
                            {{-- Name --}}
                            <x-input wire:model="state.contact_name_2" label="{{ __('Name') }}" id="name"
                                name="name" placeholder="{{ __('Enter name') }}" required autocomplete="name" />

                            {{-- Email --}}
                            <x-input wire:model="state.contact_email_2" label="{{ __('Email') }}" id="email"
                                name="email" placeholder="{{ __('Enter email') }}" required
                                autocomplete="email" />
                        </div>
                    </div>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="flex p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <x-modal-footer wireClick="savePromoter"></x-modal-footer>
            </div>
        </div>
    </div>

</div>
