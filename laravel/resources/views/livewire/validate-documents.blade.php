<div class="sm:p-6 h-screen">
    {{-- Build and company selects --}}
    <div class="flex flex-wrap gap-2 sm:gap-4">
        <x-select :async-data="route('search.builds')" option-label="name" option-value="id" wire:model="build_id" :placeholder="__('Select build')"
            class="sm:flex-1 w-full"></x-select>
        @if ($build_id)
            <x-select multiselect :async-data="route('search.companies', ['build_id' => $build_id])" option-label="name" option-value="id" wire:model="companies_id"
                :placeholder="__('Select company')" class="sm:flex-1 w-full"></x-select>
        @endif
    </div>

    @if ($build_id && $companies_id)

        {{-- Companies Accordions --}}
        <div id="accordion-flush" class="mt-5" data-accordion="collapse"
            data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
            data-inactive-classes="text-gray-500 dark:text-gray-400">
            @foreach ($companies as $key => $company)
                <h2 id="accordion-flush-heading-{{ $key }}">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 px-2 font-medium  text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                        data-accordion-target="#accordion-flush-body-{{ $key }}" aria-expanded="false"
                        aria-controls="accordion-flush-body-{{ $key }}">
                        <span class="text-center w-full ">{{ $company->name . ' ' . $company->getFullAddress() }}</span>
                        <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-{{ $key }}" class="hidden"
                    aria-labelledby="accordion-flush-heading-{{ $key }}">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-center">
                        <div class="relative overflow-x-auto sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            {{ __('Document') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            {{ __('Document type') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            {{ __('Entity') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            {{ __('Restricts access') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            {{ __('Upload date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($neededDocuments[$company->id] as $key => $entityDocuments)
                                        {{-- Get documents for each entity --}}
                                        @foreach ($entityDocuments as $entityModel)
                                            {{-- Show documents for each model from entity --}}
                                            @forelse ($entityModel as $document)
                                                <tr
                                                    class="dark:text-gray-500 text-gray-900 {{ $document->getLatestValidation()->first()->id == config('constants.DOCUMENT_VALIDATION_ID.Validado') ? 'bg-lime-100' : 'bg-red-200 dark:bg-red-300 ' }}">
                                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">

                                                        {{ $document->name }}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        {{ $document->name }}

                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $document->entity->name }}
                                                        {{-- If the entity looped is not Company, get the owner name and nif --}}
                                                        @php
                                                            if ($key != config('constants.ENTITY_TEMPLATE_ID.Company')) {
                                                                $owner = $document->ownerEntity($key, $document->owner_id);
                                                            }
                                                        @endphp
                                                        <span class="block font-bold">
                                                            {{ isset($owner) ? '(' . $owner->name . ', ' . $owner->nif . ')' : '' }}</span>

                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $document->restricts_access ? __('Yes') : __('No') }}

                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $document->getLatestValidation()->first()->name }}
                                                        {{ $document->getLatestValidation()->first()->id != config('constants.DOCUMENT_VALIDATION_ID.Pendiente') ? '(' . $document->getLatestValidation()->first()->created_at . ')' : '' }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $document->created_at }}

                                                    </td>
                                                    <td title="{{ __('validate') }}" class="px-6 py-4">
                                                        {{-- Action buttons --}}
                                                        <svg wire:click="$emit('openModal','validation-modal',{document: {{ $document->id }},company: {{ $company->id }}})"
                                                            class="w-5 h-5 cursor-pointer m-auto text-gray-900"
                                                            viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.26279 3.25871C7.38317 2.12953 8.33887
                                                                .25 9.5 1.25H14.5C15.6611 1.25 16.6168 2.12953
                                                                16.7372 3.25871C17.5004 3.27425 18.1602 3.31372
                                                                18.7236 3.41721C19.4816 3.55644 20.1267 3.82168
                                                                20.6517 4.34661C21.2536 4.94853 21.5125 5.7064
                                                                21.6335 6.60651C21.75 7.47348 21.75 8.5758
                                                                21.75 9.94339V16.0531C21.75 17.4207 21.75 18.523
                                                                21.6335 19.39C21.5125 20.2901 21.2536 21.048
                                                                20.6517 21.6499C20.0497 22.2518 19.2919 22.5107
                                                                18.3918 22.6317C17.5248 22.7483 16.4225 22.7483
                                                                15.0549 22.7483H8.94513C7.57754 22.7483 6.47522
                                                                22.7483 5.60825 22.6317C4.70814 22.5107 3.95027
                                                                22.2518 3.34835 21.6499C2.74643 21.048 2.48754
                                                                20.2901 2.36652 19.39C2.24996 18.523 2.24998 17.4207
                                                                2.25 16.0531V9.94339C2.24998 8.5758 2.24996 7.47348
                                                                2.36652 6.60651C2.48754 5.7064 2.74643 4.94853 3.34835
                                                                4.34661C3.87328 3.82168 4.51835 3.55644 5.27635 3.41721C5.83977
                                                                3.31372 6.49963 3.27425 7.26279 3.25871ZM7.26476 4.75913C6.54668
                                                                4.77447 5.99332 4.81061 5.54735 4.89253C4.98054 4.99664 4.65246
                                                                5.16382 4.40901 5.40727C4.13225 5.68403 3.9518 6.07261 3.85315
                                                                6.80638C3.75159 7.56173 3.75 8.56285 3.75 9.99826V15.9983C3.75 17.4337
                                                                3.75159 18.4348 3.85315 19.1901C3.9518 19.9239 4.13225 20.3125 4.40901
                                                                20.5893C4.68577 20.866 5.07435 21.0465 5.80812 21.1451C6.56347 21.2467
                                                                7.56458 21.2483 9 21.2483H15C16.4354 21.2483 17.4365 21.2467 18.1919
                                                                21.1451C18.9257 21.0465 19.3142 20.866 19.591 20.5893C19.8678 20.3125
                                                                20.0482 19.9239 20.1469 19.1901C20.2484 18.4348 20.25 17.4337 20.25
                                                                15.9983V9.99826C20.25 8.56285 20.2484 7.56173 20.1469 6.80638C20.0482
                                                                6.07261 19.8678 5.68403 19.591 5.40727C19.3475 5.16382 19.0195 4.99664
                                                                18.4527 4.89253C18.0067 4.81061 17.4533 4.77447 16.7352 4.75913C16.6067
                                                                5.87972 15.655 6.75 14.5 6.75H9.5C8.345 6.75 7.39326 5.87972 7.26476
                                                                4.75913ZM9.5 2.75C9.08579 2.75 8.75 3.08579 8.75 3.5V4.5C8.75 4.91421
                                                                9.08579 5.25 9.5 5.25H14.5C14.9142 5.25 15.25 4.91421 15.25 4.5V3.5C15.25
                                                                3.08579 14.9142 2.75 14.5 2.75H9.5ZM15.5483 10.4883C15.8309 10.7911 15.8146
                                                                11.2657 15.5117 11.5483L11.226 15.5483C10.9379 15.8172 10.4907 15.8172 10.2025
                                                                15.5483L8.48826 13.9483C8.18545 13.6657 8.16908 13.1911 8.45171 12.8883C8.73433
                                                                12.5854 9.20893 12.5691 9.51174 12.8517L10.7143 13.9741L14.4883 10.4517C14.7911
                                                                10.1691 15.2657 10.1854 15.5483 10.4883Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="p-4">
                                                        @if ($key == 1)
                                                            {{ __('There is no uploaded documents.') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforelse
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
