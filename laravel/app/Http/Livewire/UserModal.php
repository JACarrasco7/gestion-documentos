<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use LivewireUI\Modal\ModalComponent;

class UserModal extends ModalComponent
{
    public User $user;
    public array $state = [];
    public $selectRole_user, $currentRole_user;
    public $insert = true;
    public $company_id;

    /**
     * Function to mount modal according to procces
     *
     */
    public function mount()
    {
        try {
            // Get data User for Modify
            $this->state = $this->user->toArray();

            // Select value
            $this->selectRole_user = $this->user->roles[0]->id; // role input select
            $this->currentRole_user = $this->user->roles[0]->id; // current role assigned
            $this->company_id = $this->user->company_id;
            // Action
            $this->insert = false;
        } catch (\Throwable $th) {
            // Initialize new User
            $this->user = new User;
        }
    }

    /**
     * Function to render modal
     *
     */
    public function render()
    {
        return view('livewire.user-modal');
    }

    /**
     * Function to sets the size of the modal
     *
     * @return string
     */
    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    /**
     * Function to set validation rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'username' => 'required|string|' . Rule::unique(User::class)->ignore($this->user->id),
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'selectRole_user' => 'required'
        ];
    }

    /**
     * Function to prepare data, save or modify an User
     * and send data to the table to save
     */
    public function saveUser()
    {
        // Get rules for validation according to action
        if ($this->insert) {
            $this->state['selectRole_user'] = $this->selectRole_user;
            $rules = $this->rules();
        } else {
            $this->state['selectRole_user'] = $this->selectRole_user;
            $this->state['currentRole_user'] = $this->currentRole_user;
            $rules = $this->rulesEdit();
        }

        // Validate data inputs
        $validateData = Validator::make($this->state, $rules)->validate();

        // Validate and add the company to validated data
        if ($this->state['selectRole_user'] === 2) {
            $company_id = Validator::make(['company_id' => $this->company_id], ['company_id' => 'required'])->validate()['company_id'];
            $validateData['company_id'] = $company_id;
            // Log::debug(print_r($company_id,true));
        }

        //If is edit or create and enter password is validated, encrypt
        if (isset($validateData['password'])) {
            // Encrypt password
            $validateData['password'] = bcrypt($validateData['password']);
        }

        //If data es validated, send to table for save ($this->user is optional, Only use for modification)
        if ($validateData) {
            $this->emitTo('user-table', 'saveUser', $validateData, $this->user->id);
        }
    }

    /**
     * Get different validation rules for user modification
     *
     * @return array
     */
    public function rulesEdit(): array
    {
        //Get all validation rules
        $rules = $this->rules();

        // If is edit and not enter password, not validate password.
        // because not required and get the current password
        if (empty($this->state['password'])) {
            unset($rules['password']);
            unset($rules['password_confirmation']);
        }

        if ($this->selectRole_user != $this->currentRole_user) {
            $rules['currentRole_user'] = 'required';
        }

        return $rules;
    }
}
