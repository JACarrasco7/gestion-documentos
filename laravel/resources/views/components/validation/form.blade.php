{{-- Form to validate a document --}}
<div class="flex flex-col sm:gap-4 gap-2">
    {{-- Status select --}}
    <x-select wire:model="validation_id" placeholder="{{ __('Select status') }}" :options="Helpers::getValidation()"
        name="status" option-label="name" option-value="id" />

    {{-- Observations field --}}
    <x-textarea rows=1 wire:model="observations" id="observations" name="observations" placeholder="{{ __('Observations') }}"
        autocomplete="observations"></x-textarea>

    <button
        class="grow justify-center p-3 text-sm font-medium text-white
                transition-all ease-in duration-150 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded-lg bg-blue-500 hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600"
        wire:click="save">
        {{ __('Save') }}
    </button>

</div>
