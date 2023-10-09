<?php

namespace App\Http\Livewire;

use App\Models\Promoter;
use App\Rules\phone;
use App\Rules\postal_code;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class PromoterModal extends ModalComponent
{
    public Promoter $promoter;
    public array $state = [];
    public $insert = true;

    /**
     * Mount modal according to procces
     *
     */
    public function mount()
    {
        try {
            // Get data User for Modify
            $this->state = $this->promoter->toArray();
            $this->state += $this->promoter->contact_info->toArray();

            // Action
            $this->insert = false;
        } catch (\Throwable $th) {
            // Initialize new Promoter
            $this->promoter = new Promoter;
        }
    }

    /**
     * Function to render modal
     *
     */
    public function render()
    {
        return view('livewire.promoter-modal');
    }

    /**
     * Function to sets the size of the modal
     *
     * @return string
     */

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    /**
     * Function to set validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'sometimes|email',
            'phone_1' => ['required', new Phone],
            'phone_2' => ['sometimes', new Phone],
            'province' => 'sometimes',
            'city' => 'sometimes',
            'postal_code' => ['sometimes', new Postal_code],
            'address' => 'sometimes',
            'contact_name_1' => 'sometimes',
            'contact_email_1' => 'sometimes|email',
            'contact_name_2' => 'sometimes',
            'contact_email_2' => 'sometimes|email',
        ];
    }

    /**
     * Function to prepare data save new promoter or modification promoter
     * and send data to table to save
     */
    public function savePromoter()
    {
        // Validate data inputs
        $validateData = Validator::make($this->state, $this->rules())->validate();

        //If data es validated, send to table for save ($this->promoter is optional, Only use for modification)
        if ($validateData) {
            $this->emitTo('promoter-table', 'savePromoter', $validateData, $this->promoter->id);
        }
    }
}
