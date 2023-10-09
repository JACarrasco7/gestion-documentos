<div>
    <div class="relative w-full sm:h-[90vh]">
        <!-- Modal content -->
        <div class="relative bg-white h-full rounded-lg shadow dark:bg-gray-700 dark:text-gray-200">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ __('Validate document') . ' "' . $document->name . '"' }}
                </h3>
                <button wire:click="close()"
                    class="inline-flex items-center justify-center w-8 h-8 ml-auto text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="staticModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-2 sm:p-6 grid grid-cols-1 sm:h-5/6 md:grid-cols-2 justify-center items-start">
                {{-- Document preview --}}
                <div class="flex items-center h-96 sm:h-full justify-center">
                    <iframe class="w-full h-full" frameborder="0"
                        src="{{ asset('..\storage\app\public\temp\/') . $document->name }}"
                        type="application/pdf"></iframe>
                </div>
                <div class="flex flex-col justify-start pt-5 sm:pt-0 sm:px-12 sm:gap-4 gap-2">
                    {{-- Document and company data --}}
                    <h4 class="sm:text-lg text-base font-bold">
                        {{ __('Company') . ': ' . $company->name . ' (' . $company->especialty->name . ')' }}</h4>

                    {{-- Uplaoded date --}}
                    <p class="font-bold">{{ __('Upload date') . ': ' . $document->created_at }}</p>

                    {{-- document type --}}
                    <p class="font-bold">
                        {{ __('Document type') . ': ' . $document->document_type->name . ' (' . $document->document_type->max_docs . ' max)' }}
                    </p>

                    {{-- Relate entity --}}
                    <p class="font-bold">
                        {{ __('Related entity') . ': ' . $document->entity->name }}
                    </p>

                    {{-- Latest validations --}}
                    <div>
                        <p class="font-bold">
                            {{ __('Lastests validations') }}
                        </p>

                        @if (count($validations) > 0)

                            <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                {{ __('Status') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ __('Observations') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ __('Date') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($validations as $key=> $validation)

                                            <tr
                                                class="{{$key==0?'bg-slate-100 dark:bg-slate-900':'bg-white dark:bg-gray-800'}} border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <th scope="row"
                                                    class="p-2 sm:px-6 sm:py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $validation->name }}
                                                </th>
                                                <td class="p-2 sm:px-6 sm:py-4">
                                                    {{ $validation->pivot->observations }}
                                                </td>
                                                <td class="p-2 sm:px-6 sm:py-4">
                                                    {{ $validation->pivot->created_at->format('d-m-Y H:i') }}
                                                </td>

                                            </tr>
                                        @empty
                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                        @else
                            <span class="p-2">{{ __('No revisions done.') }}</span>

                        @endif

                    </div>

                <h5 class="text-lg font-semibold">{{__('Update validation')}}</h5>
                    <x-validation.form></x-validation.form>
                </div>
            </div>
        </div>
    </div>
</div>
