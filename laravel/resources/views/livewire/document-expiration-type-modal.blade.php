<div>

    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $insert ? __('Create') : __('Edit') }} {{ __('expiration type') }}
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
                <div class="grid grid-cols-2 gap-4 items-center">
                    {{-- Name --}}
                    <x-input wire:model="state.name" id="name" name="name"
                        placeholder="{{ __('Enter name') }}" required autocomplete="name" />

                    {{-- Validate date --}}
                    <div class="">

                        <label class="relative inline-flex items-center cursor-pointer">
                            <input wire:model="state.validate_date" type="checkbox" value="" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{__('Validate date')}}</span>
                        </label>
                    </div>

                    {{-- Description --}}
                    <div class="col-span-2">
                        <x-textarea wire:model="state.description"  id="description"
                            name="description" placeholder="{{ __('Description') }}" required
                            autocomplete="description"></x-textarea>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <x-modal-footer wireClick="save"></x-modal-footer>
            </div>
        </div>
    </div>

</div>
