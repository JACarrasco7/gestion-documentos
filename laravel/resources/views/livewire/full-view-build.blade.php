<div>
    <div class="grid grid-cols-1 gap-2 place-content-center md:grid-cols-12">
        <!-- Build Col -->
        <div class="md:col-span-4">
            <div
                class="block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 ">
                <h2>{{ __('Build information') }}</h2>
                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                <h5 class="my-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $build->name }}
                    <p class="text-sm font-normal">
                        {{ $build->getFullAddress() }}
                    </p>
                </h5>
                <!-- Tabs Build info -->
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" data-tabs-toggle="#TabBuild"
                        role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="build-tab"
                                data-tabs-target="#build" type="button" role="tab" aria-controls="build"
                                aria-selected="false">{{ __('Build') }}</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="promoters-tab" data-tabs-target="#promoters" type="button" role="tab"
                                aria-controls="promoters" aria-selected="false">{{ __('Promoter') }}</button>
                        </li>
                    </ul>
                </div>
                <div id="TabBuild">
                    <!-- Build Tab -->
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="build" role="tabpanel"
                        aria-labelledby="build-tab">
                        <p class="py-2">
                            <span class="font-bold">{{ __('Begin') }}:</span> {{ $build->start_date }}
                        </p>
                        <p class="py-1">
                            <span class="font-bold">{{ __('End') }}:</span>
                            {{ $build->end_date ? $build->end_date : __('In construction') }}
                        </p>
                        <p class="py-1">
                            <span class="font-bold">{{ __('Duration') }}:</span>
                            {{ $build->period() . ' ' . __('days') }}
                        </p>
                        <p class="py-1">
                            <span class="font-bold">{{ __('Category') }}:</span> {{ $build->category->name }}
                        </p>
                        <p class="py-1 mt-2">
                            <span class="font-bold underline decoration-solid">{{ __('Externals') }}
                        </p>
                        <ul>
                            @forelse ($build->externals as $external)
                                <li>{{ $external->name }}</li>
                            @empty
                                {{ __('Relation not defined.') }}
                            @endforelse
                        </ul>
                        <p class="py-1 mt-2">
                            <span class="font-bold underline decoration-solid">{{ __('Construction managers') }}
                        </p>
                        <ul>
                            @forelse ($build->construction_managers as $construction_manager)
                                <li>{{ $construction_manager->name }}</li>
                            @empty
                                {{ __('Relation not defined.') }}
                            @endforelse
                        </ul>
                        <div
                            class="block max-w-sm p-6 my-4 mt-8 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <p class="font-normal text-gray-700 dark:text-gray-400"> {{ $build->description }}</p>
                        </div>
                    </div>
                    <!-- Promoter Tab -->
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="promoters" role="tabpanel"
                        aria-labelledby="promoters-tab">
                        <p class="py-1 text-lg font-bold">{{ $build->promoter->name }}</p>
                        <p class="py-1 text-md">{{ $build->promoter->contact_info->email }}</p>
                        @if ($build->promoter->contact_info->phone_1)
                            <p class="py-1 text-md">{{ $build->promoter->contact_info->phone_1 }}</p>
                        @endif
                        @if ($build->promoter->contact_info->phone_2)
                            <p class="py-1 text-md">{{ $build->promoter->contact_info->phone_2 }}</p>
                        @endif
                        <p class="py-1 text-md">{{ $build->promoter->getFullAddress() }}</p>

                        <!-- Contact 1 -->
                        @if ($build->promoter->contact_name_1)
                            <div
                                class="block p-4 my-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ __('Contact') }} 1
                                </p>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                                <ul>
                                    <li>
                                        <span class="font-bold">{{ __('Name') }}:
                                        </span>{{ $build->promoter->contact_name_1 }}
                                    </li>
                                    <li>
                                        <span class="font-bold">{{ __('Email') }}:
                                        </span>{{ $build->promoter->contact_email_1 }}
                                    </li>
                                </ul>
                            </div>
                        @endif

                        <!-- Contact 2 -->
                        @if ($build->promoter->contact_name_2)
                            <div
                                class="block p-4 my-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <p class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ __('Contact') }} 1
                                </p>
                                <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                                <ul>
                                    <li>
                                        <span class="font-bold">{{ __('Name') }}:
                                        </span>{{ $build->promoter->contact_name_2 }}
                                    </li>
                                    <li>
                                        <span class="font-bold">{{ __('Email') }}:
                                        </span>{{ $build->promoter->contact_email_2 }}
                                    </li>
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>

        <!-- Documents Col -->
        <div class="md:col-span-8">
            <div class="flex justify-between">
                <ul class="py-2 space-y-1 text-gray-500 list-inside dark:text-gray-400">
                    <li class="inline-flex items-center px-4">
                        <svg class="w-3.5 h-3.5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        {{ __('Approved') }}
                    </li>

                    <li class="inline-flex items-center px-4">
                        <svg class="w-3.5 h-3.5 mr-2 text-red-600 dark:text-red-400 flex-shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        {{ __('Refused') }}
                    </li>


                    <li class="inline-flex items-center px-4">
                        <svg class="w-3.5 h-3.5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        {{ __('Pending') }}
                    </li>

                    <li class="inline-flex items-center px-4">
                        <svg class="w-3.5 h-3.5 mr-2 text-warning-500 dark:text-warning-400 flex-shrink-0"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        {{ __('Expired') }}
                    </li>
                </ul>
                <div>
                    <!-- Status select -->
                    {{-- <x-select wire:model="filter_validation" placeholder="{{ __('Select status') }}" :options="Helpers::getValidation()"
                        name="status" option-label="name" option-value="id" multiselect /> --}}
                </div>
            </div>

            <!-- Tabs Documents info -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800"
                    id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
                    <li class="mr-2">
                        <button id="documents-companies-tab" data-tabs-target="#documents-companies" type="button"
                            role="tab" aria-controls="documents-companies" aria-selected="false"
                            class="inline-block p-4 text-blue-600 rounded-tl-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">{{ __('Documents companies') }}</button>
                    </li>
                    <li class="mr-2">
                        <button id="documents-workers-tab" data-tabs-target="#documents-workers" type="button"
                            role="tab" aria-controls="documents-workers" aria-selected="false"
                            class="inline-block p-4 text-blue-600 rounded-tl-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">{{ __('Documents workers') }}</button>
                    </li>
                    <li class="mr-2">
                        <button id="documents-machines-tab" data-tabs-target="#documents-machines" type="button"
                            role="tab" aria-controls="documents-machines" aria-selected="false"
                            class="inline-block p-4 text-blue-600 rounded-tl-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">{{ __('Documents machines') }}</button>
                    </li>
                </ul>
                <div id="defaultTabContent">
                    <!-- Companies tab -->
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="documents-companies"
                        role="tabpanel" aria-labelledby="documents-companies-tab">
                        <!-- Companies collapse -->
                        <div data-accordion="false"
                            data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                            data-inactive-classes="text-gray-500 dark:text-gray-400">
                            @forelse ($documentsBuild[Company::ENTITY_ID] as $company)
                                <!-- Btn title -->
                                <h2
                                    id="accordion-heading-documents-company-{{ $company['data']->id }}">
                                    <button type="button"
                                        class="flex items-center justify-between w-full px-2 py-4 font-medium text-left text-gray-500 border-b border-gray-200 rounded-md dark:border-gray-700 dark:text-gray-400"
                                        data-accordion-target="#accordion-body-documents-company-{{ $company['data']->id }}"
                                        aria-expanded="false"
                                        aria-controls="accordion-body-documents-company-{{ $company['data']->id }}">
                                        <span class="text-lg">{{ $company['data']->name }}</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <!-- Collapse -->
                                <div id="accordion-body-documents-company-{{ $company['data']->id }}"
                                    class="hidden"
                                    aria-labelledby="accordion-heading-documents-company-{{ $company['data']->id }}">
                                    <div class="px-4 py-5 border-b border-gray-200 dark:border-gray-700">
                                        <p class="mb-2 text-gray-900 text-md dark:text-white">
                                            {{ __('Required documents:') }}
                                        </p>
                                        <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                                            {{ dd($documentsBuild[Company::ENTITY_ID]) }}
                                            @forelse ($documentsBuild[Company::ENTITY_ID] as $document)
                                                <li class="flex items-center px-4">
                                                    {{ dd($neededDocument['company_documents'][Company::ENTITY_ID][0]) }}
                                                    @if ($this->checkDocumentUpload($document, $neededDocument['company_documents'][Company::ENTITY_ID][0]))
                                                        @if ($this->checkDocumentValidate($document, $neededDocument['company_documents'][Company::ENTITY_ID][0]))
                                                            <svg class="w-3.5 h-3.5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                            </svg>
                                                        @elseif($this->checkDocumentRefused($document, $neededDocument['company_documents'][Company::ENTITY_ID][0]))
                                                            <svg class="w-3.5 h-3.5 mr-2 text-red-600 dark:text-red-400 flex-shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                            </svg>
                                                        @elseif($this->checkDocumentPending($document, $neededDocument['company_documents'][Company::ENTITY_ID][0]))
                                                            <svg class="w-3.5 h-3.5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                            </svg>
                                                        @elseif($this->checkDocumentExpired($document, $neededDocument['company_documents'][Company::ENTITY_ID][0]))
                                                            <svg class="w-3.5 h-3.5 mr-2 text-warning-500 dark:text-warning-400 flex-shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                            </svg>
                                                        @endif
                                                    @else
                                                        <svg class="w-3.5 h-3.5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                        </svg>
                                                    @endif
                                                    {{ $document->name }}
                                                </li>
                                            @empty
                                                {{ __('There are no associated documents') }}
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                {{ __('There are no associated companies') }}
                            @endforelse
                        </div>
                    </div>
                    <!-- Workers tab -->
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="documents-workers"
                        role="tabpanel" aria-labelledby="documents-workers-tab">
                        <!-- Workers collapse -->
                        <div data-accordion="collapse"
                            data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                            data-inactive-classes="text-gray-500 dark:text-gray-400">
                            @forelse ($build->workers as $worker)
                                <!-- Btn title -->
                                <h2 id="accordion-heading-documents-worker-{{ $worker->id }}">
                                    <button type="button"
                                        wire:click="getDocumentsWorkerRequired({{ $worker }}, {{ $build }})"
                                        class="flex items-center justify-between w-full px-2 py-4 font-medium text-left text-gray-500 border-b border-gray-200 rounded-md dark:border-gray-700 dark:text-gray-400"
                                        data-accordion-target="#accordion-body-documents-worker-{{ $worker->id }}"
                                        aria-expanded="false"
                                        aria-controls="accordion-body-documents-worker-{{ $worker->id }}">
                                        <span class="text-lg">{{ $worker->name }}</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <!-- Collapse -->
                                <div id="accordion-body-documents-worker-{{ $worker->id }}" class="hidden"
                                    aria-labelledby="accordion-heading-documents-worker-{{ $worker->id }}">
                                    <div class="px-4 py-5 border-b border-gray-200 dark:border-gray-700">
                                        <p class="mb-2 text-gray-900 text-md dark:text-white">
                                            {{ __('Required documents:') }}
                                        </p>
                                        <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                                            @forelse ($worker->templates as $template)
                                                @forelse ($template->document_type as $document)
                                                    @php
                                                        $documentsWorkerTemplate = $worker->getDocuments($build);
                                                        $documentsWorkerRequired = [];

                                                        foreach ($documentsWorkerTemplate as $documentWorkerTemplate) {
                                                            if (!$documentWorkerTemplate->isEmpty()) {
                                                                foreach ($documentWorkerTemplate as $key => $document_Required) {
                                                                    $documentsWorkerRequired[$document_Required->document_type_id] = [
                                                                        'document_validation_id' => $document_Required->document_validation_id,
                                                                    ];
                                                                }
                                                            }
                                                        }

                                                    @endphp
                                                    @if (in_array($document->id, $documentsWorkerRequired))
                                                        <li class="flex items-center px-4">
                                                            @if (
                                                                $documentsWorkerRequired[$document->id]['document_validation_id'] ==
                                                                    config('constants.DOCUMENT_VALIDATION_ID.Validado'))
                                                                <svg class="w-3.5 h-3.5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                                </svg>
                                                            @elseif(
                                                                $documentsWorkerRequired[$document->id]['document_validation_id'] ==
                                                                    config('constants.DOCUMENT_VALIDATION_ID.Rechazado'))
                                                                <svg class="w-3.5 h-3.5 mr-2 text-red-600 dark:text-red-400 flex-shrink-0"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                                </svg>
                                                            @elseif(
                                                                $documentsWorkerRequired[$document->id]['document_validation_id'] ==
                                                                    config('constants.DOCUMENT_VALIDATION_ID.Pendiente'))
                                                                <svg class="w-3.5 h-3.5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                                </svg>
                                                            @elseif(
                                                                $documentsWorkerRequired[$document->id]['document_validation_id'] ==
                                                                    config('constants.DOCUMENT_VALIDATION_ID.Caducado'))
                                                                <svg class="w-3.5 h-3.5 mr-2 text-warning-500 dark:text-warning-400 flex-shrink-0"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                                </svg>
                                                            @endif
                                                            {{ $document->name }}
                                                        </li>
                                                    @else
                                                        <li class="flex items-center px-4">
                                                            <svg class="w-3.5 h-3.5 mr-2 text-red-600 dark:text-red-400 flex-shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                            </svg>
                                                            {{ $document->name }}
                                                        </li>
                                                    @endif
                                                @empty
                                                    {{ __('There are no associated documents') }}
                                                @endforelse
                                            @empty
                                                {{ __('There are no associated documents templates') }}
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                {{ __('There are no associated worker') }}
                            @endforelse
                        </div>
                    </div>
                    <!-- Machines tab -->
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="documents-machines"
                        role="tabpanel" aria-labelledby="documents-machines-tab">
                        <!-- Machines collapse -->
                        <div data-accordion="collapse"
                            data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                            data-inactive-classes="text-gray-500 dark:text-gray-400">
                            @forelse ($build->machines as $machine)
                                <!-- Btn title -->
                                <h2 id="accordion-heading-documents-machine-{{ $machine->id }}">
                                    <button type="button"
                                        wire:click="getDocumentsMachineRequired({{ $machine }}, {{ $build }})"
                                        class="flex items-center justify-between w-full px-2 py-4 font-medium text-left text-gray-500 border-b border-gray-200 rounded-md dark:border-gray-700 dark:text-gray-400"
                                        data-accordion-target="#accordion-body-documents-machine-{{ $machine->id }}"
                                        aria-expanded="false"
                                        aria-controls="accordion-body-documents-machine-{{ $machine->id }}">
                                        <span class="text-lg">{{ $machine->name }}</span>
                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <!-- Collapse -->
                                <div id="accordion-body-documents-machine-{{ $machine->id }}" class="hidden"
                                    aria-labelledby="accordion-heading-documents-machine-{{ $machine->id }}">
                                    <div class="px-4 py-5 border-b border-gray-200 dark:border-gray-700">
                                        <p class="mb-2 text-gray-900 text-md dark:text-white">
                                            {{ __('Required documents:') }}
                                        </p>
                                        <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                                            @forelse ($machine->templates->document_type as $document)
                                                @if (in_array($document->id, $KeysDocumentsMachineRequired))
                                                    <li class="flex items-center px-4">
                                                        @if (
                                                            $documentsMachineRequired[$document->id]['document_validation_id'] ==
                                                                config('constants.DOCUMENT_VALIDATION_ID.Validado'))
                                                            <svg class="w-3.5 h-3.5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                            </svg>
                                                        @elseif(
                                                            $documentsMachineRequired[$document->id]['document_validation_id'] ==
                                                                config('constants.DOCUMENT_VALIDATION_ID.Rechazado'))
                                                            <svg class="w-3.5 h-3.5 mr-2 text-red-600 dark:text-red-400 flex-shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                            </svg>
                                                        @elseif(
                                                            $documentsMachineRequired[$document->id]['document_validation_id'] ==
                                                                config('constants.DOCUMENT_VALIDATION_ID.Pendiente'))
                                                            <svg class="w-3.5 h-3.5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                            </svg>
                                                        @elseif(
                                                            $documentsMachineRequired[$document->id]['document_validation_id'] ==
                                                                config('constants.DOCUMENT_VALIDATION_ID.Caducado'))
                                                            <svg class="w-3.5 h-3.5 mr-2 text-warning-500 dark:text-warning-400 flex-shrink-0"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                            </svg>
                                                        @endif
                                                        {{ $document->name }}
                                                    </li>
                                                @else
                                                    <li class="flex items-center px-4">
                                                        <svg class="w-3.5 h-3.5 mr-2 text-red-600 dark:text-gray-600 flex-shrink-0"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                        </svg>
                                                        {{ $document->name }}
                                                    </li>
                                                @endif
                                            @empty
                                                {{ __('There are no associated documents') }}
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                {{ __('There are no associated machines') }}
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
