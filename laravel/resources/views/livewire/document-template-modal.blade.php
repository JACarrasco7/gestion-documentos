<div>

    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $insert ? __('Create') : __('Edit') }} {{ __('document template') }}
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
            <div class="p-4 space-y-6">
                <div class="grid grid-cols-10 gap-4">
                    <div class="col-span-3">
                        <x-input wire:model="state.name" label="{{ __('Name') }}" id="name" name="name"
                            placeholder="{{ __('Enter name') }}" required autocomplete="name" />
                    </div>

                    {{-- Entity --}}
                    <div class="col-span-3">
                        <x-select wire:model="entity" label="{{ __('Entity') }}"
                            placeholder="{{ __('Select entity') }}" :options="$this->getEntities()" id="entity" name="entity"
                            option-label="name" option-value="id" />
                    </div>
                    <div class="col-span-4">
                        <x-input wire:model="state.description" label="{{ __('Description') }}" id="description"
                            name="description" placeholder="{{ __('Description') }}" required
                            autocomplete="description"></x-input>
                    </div>
                </div>

                <div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <caption
                                class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">

                                <div class="flex justify-between pt-2">
                                    <p class="mt-3 text-sm font-normal text-gray-500 dark:text-gray-400">
                                        {{ __('You must select an entity to see the documents.') }}</p>
                                    <div>
                                        <x-input icon="search" wire:model="filter_search" id="filter_search"
                                            name="filter_search" placeholder="{{ __('Search') }}..." required
                                            autocomplete="filter_search" />
                                    </div>
                                </div>

                            </caption>
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-600 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-all-search" type="checkbox" wire:model="selectAll"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Document') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            {{ __('Description') }}
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            {{ __('Expiration') }}
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($document_types->isEmpty() || !$entity)

                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="4" class="px-6 py-4 text-center">
                                            {{ __('No results found') }}
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($document_types as $document_type)
                                        <tr
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-500">
                                            <td class="w-4 p-4">
                                                <div class="flex items-center">
                                                    <input
                                                        {{ array_key_exists($document_type->id, $documents_check) ? 'checked' : '' }}
                                                        id="checkbox-table-search-1" type="checkbox"
                                                        wire:click="checkDocument({{ $document_type->id }})"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                </div>
                                            </td>
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $document_type->name }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $document_type->description }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $document_type->expiration->name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{ $document_types->links() }}
                    </div>

                </div>
                @error('documents_check')
                <span class="mt-2 text-sm text-center text-negative-600">{{ $message }}</span>
            @enderror
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
