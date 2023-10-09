<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalConditions extends Component
{
    public function render()
    {
        return view('livewire.modal-conditions');
    }

    public function acceptConditions()
    {
        $user = User::find(Auth::user()->id);
        $user->update(['accepted_condition' => true]);
        $this->emit('closeModalConditions');
    }
}
