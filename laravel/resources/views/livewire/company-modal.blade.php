<div>

    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $insert ? __('Create') : __('Edit') }} {{ __('company') }}
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
                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                    {{-- Name --}}
                    <x-input wire:model="state.name" label="{{ __('Name') }}" id="name" name="name"
                        placeholder="{{ __('Enter name') }}" required autocomplete="name" />

                    {{-- Cif --}}
                    <x-input mas wire:model="state.cif" label="{{ __('CIF') }}" id="cif" name="cif"
                        placeholder="{{ __('Enter nif') }}" required autocomplete="cif" />

                    {{-- Teléfono --}}
                    <x-input pattern="[0-9]" wire:model="state.phone_1" label="{{ __('Phone') }}" id="phone"
                        name="phone_1" placeholder="{{ __('Enter phone') }}" required autocomplete="phone"
                        onKeyPress="if(this.value.length==9) return false;" />

                    {{-- Experience --}}
                    <x-input type="number" wire:model="state.experience" label="{{ __('Experience') }}" id="experience"
                        experience="experience" placeholder="{{ __('Enter experience') }}" required
                        autocomplete="experience" />

                    {{-- Document template --}}
                    <x-select wire:model.defer="document_template" label="{{ __('Select document template') }}"
                        placeholder="{{ __('Select document template') }}" :async-data="route('search.templates', ['entity_id' => $entity_id])" option-label="name"
                        option-value="id" />

                    {{-- Especialty --}}
                    <x-select wire:model="especialty_id" label="{{ __('Select especialty') }}"
                        placeholder="{{ __('Select especialty') }}" :options="$this->getEspecialties()" id="select_especialty"
                        name="select_especialty" option-label="name" option-value="id" />

                    {{-- Province --}}
                    <x-input wire:model="state.province" label="{{ __('Province') }}" id="province" name="province"
                        placeholder="{{ __('Enter province') }}" required autocomplete="province" />

                    {{-- City --}}
                    <x-input wire:model="state.city" label="{{ __('City') }}" id="city" name="city"
                        placeholder="{{ __('Enter city') }}" required autocomplete="city" />

                    {{-- Postal code --}}
                    <x-input wire:model="state.postal_code" label="{{ __('Postal code') }}" id="postal_code"
                        name="postal_code" placeholder="{{ __('Enter postal code') }}" required
                        autocomplete="postal_code" onKeyPress="if(this.value.length==5) return false;" />

                    {{-- Address --}}
                    <x-input wire:model="state.address" label="{{ __('Address') }}" id="address" name="address"
                        placeholder="{{ __('Enter address') }}" required autocomplete="address" />
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <x-modal-footer wireClick="save"></x-modal-footer>

            </div>
        </div>
    </div>

</div>
