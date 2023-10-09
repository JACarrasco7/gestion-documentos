<div>

    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $insert ? __('Create') : __('Edit') }} {{ __('Build') }}
                </h3>
                <button wire:click="$emit('closeModal')"
                    class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="staticModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">{{ __('Close modal') }}</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <div class="grid gap-4 sm:grid-cols-2">

                    <div class="grid sm:grid-cols-3 sm:col-span-2 gap-4">

                        {{-- Name --}}
                        <x-input wire:model="state.name" label="{{ __('Name') }}" id="name" name="name"
                            placeholder="{{ __('Enter name') }}" required autocomplete="name" />

                        {{-- Category --}}
                        <x-select wire:model.defer="category" label="{{ __('Select category') }}"
                            placeholder="{{ __('Select category') }}" :async-data="route('search.build_categories')" option-label="name"
                            option-value="id" />

                        {{-- Promoter --}}
                        <x-select wire:model.defer="promoter" label="{{ __('Select promoter') }}"
                            placeholder="{{ __('Select promoter') }}" :async-data="route('search.promoters')" option-label="name"
                            option-value="id" />

                        {{-- Start date --}}
                        <x-datetime-picker without-time label="{{ __('Start date') }}"
                            placeholder="{{ __('Enter start date') }}" parse-format="DD-MM-YYYY"
                            wire:model="start_date" />

                        {{-- End date --}}
                        <x-datetime-picker without-time label="{{ __('End date') }}"
                            placeholder="{{ __('Enter end date') }}" parse-format="DD-MM-YYYY" wire:model="end_date" />

                    </div>

                    <div class="grid sm:grid-cols-2 sm:col-span-2 gap-4">

                        {{-- External --}}
                        <x-select wire:model.defer="externals" label="{{ __('Select external') }}"
                            placeholder="{{ __('Select external') }}" multiselect :async-data="route('search.externals')" option-label="name"
                            option-value="id" />

                        {{-- Construction manager --}}
                        <x-select wire:model.defer="construction_managers"
                            label="{{ __('Select construction manager') }}"
                            placeholder="{{ __('Select construction manager') }}" multiselect :async-data="route('search.construction_managers')"
                            option-label="name" option-value="id" />

                    </div>

                    <div class="grid sm:grid-cols-3 sm:col-span-2 gap-4">

                        {{-- Teléfono --}}
                        <x-input pattern="[0-9]" wire:model="state.phone_1" label="{{ __('Phone') }}" id="phone_1"
                            name="phone_1" placeholder="{{ __('Enter phone') }}" required autocomplete="phone_1"
                            onKeyPress="if(this.value.length==9) return false;" />

                        {{-- Province --}}
                        <x-input wire:model="state.province" label="{{ __('Province') }}" id="province"
                            name="province" placeholder="{{ __('Enter province') }}" required
                            autocomplete="province" />

                        {{-- City --}}
                        <x-input wire:model="state.city" label="{{ __('City') }}" id="city" name="city"
                            placeholder="{{ __('Enter city') }}" required autocomplete="city" />
                    </div>

                    <div class="grid sm:grid-cols-5 sm:col-span-2 gap-4">

                        {{-- Postal code --}}
                        <x-input wire:model="state.postal_code" label="{{ __('Postal code') }}" id="postal_code"
                            name="postal_code" placeholder="{{ __('Enter postal code') }}" required
                            autocomplete="postal_code" onKeyPress="if(this.value.length==5) return false;" />

                        {{-- Address --}}
                        <div class="sm:col-span-4">
                            <x-input wire:model="state.address" label="{{ __('Address') }}" id="address"
                                name="address" placeholder="{{ __('Enter address') }}" required
                                autocomplete="address" />
                        </div>

                    </div>
                    {{-- Description --}}
                    <div class="sm:col-span-2">
                        <x-textarea wire:model="state.description" label="{{ __('Description') }}" id="description"
                            name="description" placeholder="{{ __('Description') }}" required
                            autocomplete="description"></x-textarea>
                    </div>

                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <x-modal-footer wireClick="saveBuild"></x-modal-footer>

            </div>
        </div>
    </div>

</div>
