<div>

    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $insert ? __('Create') : __('Edit') }} {{ __('document type') }}
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
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-4">
                    {{-- Name --}}
                    <x-input wire:model="state.name" label="{{ __('Name') }}" id="name" name="name"
                        placeholder="{{ __('Enter name') }}" autocomplete="name" />

                    {{-- Entities --}}
                    <x-select wire:model="entity" label="{{ __('Select entity') }}"
                        placeholder="{{ __('Select entity') }}" :options="$this->getEntities()" id="select_entity"
                        name="select_entity" option-label="name" option-value="id" />

                    {{-- Max docs --}}
                    <x-input wire:model="state.max_docs" type="number" label="{{ __('Max docs') }}" name="max_docs" />
                    {{-- restricts_access --}}

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input wire:model="state.restricts_access" type="checkbox" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                        <span
                            class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Restricts access') }}</span>
                    </label>

                    {{-- Type --}}
                    <x-select wire:model="type" label="{{ __('Select type') }}" placeholder="{{ __('Select type') }}"
                        :options="config('constants.TYPE_DOCUMENT_TYPE_ES')"
                         />

                    {{-- Expirations --}}
                    <x-select wire:model="expiration" label="{{ __('Select expiration') }}"
                        placeholder="{{ __('Select expiration') }}" :options="$this->getExpirations()" id="select_expiration"
                        name="select_expiration" option-label="name" option-value="id" />

                    <x-textarea wire:model="state.description" label="{{ __('Description') }}" id="description"
                        name="description" placeholder="{{ __('Description') }}" required
                        autocomplete="description"></x-textarea>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <x-button wire:click="save"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ __('Save') }}
                </x-button>
                <x-button wire:click="$emit('closeModal')"
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    {{ __('Cancel') }}
                </x-button>
            </div>
        </div>
    </div>

</div>
