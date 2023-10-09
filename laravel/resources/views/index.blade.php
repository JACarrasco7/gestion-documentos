<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            @if ($table == 'full-view-build')
                {{ __('Build sheet') }}
            @else
                {{ __('' . ucfirst(explode('-', $table)[0])) }}
            @endif
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    @livewire($table, ['id' => isset($id) ? $id : ''])
                    @if (!Request()->get('accepted_condition'))
                        @livewire('modal-conditions')
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
