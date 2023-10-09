<div>
    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $insert ? __('Create') : __('Edit') }} {{ __('entity') }}
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

                    <!-- Input name -->
                    <x-input wire:model="state.name" label="{{ __('Name') }}" id="name" name="name"
                        placeholder="{{ __('Enter name') }}" required autocomplete="name" />

                    <!-- Input description -->
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
