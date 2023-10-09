@php
    // Shared classes
    $defaultClass = 'grow inline-flex justify-center items-center p-3 text-sm font-medium text-white
                transition-all ease-in duration-150 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded-lg';
    // Shared attributes
    $defaultAttributes = [
        'type' => 'button',
    ];

    // Own attributes and classes
    $defaultAttributesPrimary = ['class' => $defaultClass . ' bg-blue-500 hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600', 'wire:click' => isset($wireClick) ? $wireClick : null];
    $defaultAttributesSecondary = ['class' => $defaultClass . ' bg-slate-400 hover:bg-slate-500 dark:hover:bg-slate-500 dark:bg-slate-600'];

    // Own texts
    $textPrimary = isset($btn) ? $btn : __('Save');
    $textSecondary = isset($btn2) ? $btn2 : __('Cancel');
@endphp

{{-- Save button --}}
<button {{ $attributes->merge($defaultAttributesPrimary) }}>
    {{ $textPrimary }}
</button>

{{-- Cancel button --}}
<button wire:click="$emit('closeModal')" {{ $attributes->merge($defaultAttributesSecondary) }}>
    {{ $textSecondary }}
</button>
