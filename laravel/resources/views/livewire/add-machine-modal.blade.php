<div>

    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ __('Add machine') . ' ' . __('to build') . ' "' . $build->name . '"' }}
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
                <div class="grid grid-cols-1 gap-4">

                    {{-- machines --}}
                    <x-select wire:model.defer="machine_id" label="{{ __('Select machine') }}"
                        placeholder="{{ __('Select machine') }}" multiselect :async-data="route('search.machines', ['company_id' => auth()->user()->company_id])" option-label="name"
                        option-value="id" />

                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <x-modal-footer wireClick="save"></x-modal-footer>

            </div>
        </div>
    </div>

</div>
