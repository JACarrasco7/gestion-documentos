<?php

namespace App\Http\Livewire;

use App\Models\Build;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class ViewBuildModal extends ModalComponent
{
    public Build $build;

    protected $listeners = ['saved' => 'render'];

    public function render()
    {
        $this->build = Build::find($this->build->id);
        return view('livewire.view-build-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

}
