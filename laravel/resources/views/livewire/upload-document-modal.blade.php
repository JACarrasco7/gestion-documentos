<div>
    <x-notifications />
    <div class="relative w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ __('Upload documents') . ' ' . __('to build') . ' "' . $build->name . '"' }}
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

                    {{-- Tabs --}}
                    <div class="mb-4 border-b border-gray-200 dark:border-gray-600">
                        <ul class="flex flex-wrap -mb-px text-sm dark:text-gray-400 font-medium text-center justify-between"
                            id="myTab" data-tabs-toggle="#directoryTabs" role="tablist">
                            @foreach ($entities as $key => $directory)
                                <li class="mr-2 grow cursor-pointer {{ $tab === $directory ? 'border-b-2' : 'hover:bg-gray-50 dark:hover:bg-gray-600' }} border-red-400"
                                    wire:click="setTab('{{ $directory }}')" role="presentation">
                                    <button class="inline-block p-4  rounded-t-lg" id="{{ $directory }}-tab"
                                        data-tabs-target="#1" type="button" role="tab"
                                        aria-controls="{{ $directory }}"
                                        aria-selected="false">{{ $directory }}</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- Content --}}
                    <div id="directoryTabs">
                        @foreach ($entities as $key => $directory)
                            <div
                                class="{{ $tab != $directory ? 'hidden' : '' }} p-4 rounded-lg bg-gray-50 dark:bg-gray-800 text-sm text-gray-500 dark:text-gray-400">
                                <ul class="">

                                    @forelse ($entityModels as $entity)
                                        <li class="text-xl font-bold">
                                            {{ $entity->name }}
                                            <ul>
                                                @forelse ($entity->templates()->get() as $template)
                                                    @forelse ($template->document_type as $doc_type)
                                                        <li class="list-disc font-normal text-base ml-3">
                                                            <label for="file-{{ $entity->id . $doc_type->id }}">
                                                                <span
                                                                    class="cursor-pointer text-lg font-bold">{{ $doc_type->name . '(' . $doc_type->max_docs . ' max)->' }}</span>
                                                                @if (isset($state[$entity->id][$doc_type->id]))
                                                                    @foreach ($state[$entity->id][$doc_type->id] as $doc)
                                                                        {{ '(' . $doc->getClientOriginalName() . ')' }}

                                                                    @endforeach
                                                                @endif

                                                            </label>
                                                            {{-- Old file (if exists) --}}
                                                            @if (isset($old_files[$entity->id][$doc_type->id]))
                                                            <span class="inline-flex items-center gap-4">

                                                                    @forelse ($old_files[$entity->id][$doc_type->id] as $doc)
                                                                        {{ '(' . $doc->name . ', ' . $doc->getLatestValidation()->first()->name . ')' }}
                                                                        @empty
                                                                        {{__('No uploaded files.')}}
                                                                    @endforelse

                                                                </span>
                                                            @else
                                                                <span>{{ __('No uploaded file.') }}</span>
                                                            @endif
                                                            <input type="file" class="hidden"
                                                                @disabled(isset($old_files[$entity->id][$doc_type->id][0])
                                                                        ? ($old_files[$entity->id][$doc_type->id][0]->getLatestValidation()->first()->id !=
                                                                        config('constants.DOCUMENT_VALIDATION_ID.Validado')
                                                                            ? false
                                                                            : true)
                                                                        : false) multiple
                                                                id="file-{{ $entity->id . $doc_type->id }}"
                                                                wire:model="state.{{ $entity->id }}.{{ $doc_type->id }}">
                                                            @error('state.' . $entity->id . '.' . $doc_type->id)
                                                                <span class="text-red-500">{{ $message }}</span>
                                                            @enderror
                                                        </li>

                                                    @empty
                                                    @endforelse
                                                @empty
                                                    <p class="font-normal text-base ml-3">
                                                        {{ __('There is no needed documents.') }}</p>
                                                @endforelse
                                            </ul>
                                        </li>

                                    @empty
                                        <p class="font-normal text-base ml-3">
                                            {{ __('There is no linked entity.') }}</p>
                                    @endforelse
                                </ul>
                                <p class="mt-5">{{ __('Click in documents type to upload a document.') }}
                                    {{ '(' . __('You will only be able to change the file if it is pending validation.') . ')' }}
                                </p>
                                <p class="">
                                    {{ __('If uploaded documents limit is exceeded, latest document will be replaced.') }}
                                </p>
                                @error('state')
                                    <span class="text-red-500 text-base">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <x-modal-footer wireClick="save"></x-modal-footer>
            </div>
        </div>
    </div>
</div>
