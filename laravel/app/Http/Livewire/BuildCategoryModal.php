<?php

namespace App\Http\Livewire;

use App\Models\BuildCategory;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class BuildCategoryModal extends ModalComponent
{
    public BuildCategory $category;
    public array $state = [];
    public $insert = true;

    public function mount()
    {
        try {
            $this->state = $this->category->toArray();
            $this->insert = false;
        } catch (\Throwable $th) {
            $this->category = new BuildCategory;
        }
    }
    
    public function render()
    {
        return view('livewire.build-category-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'description' => 'sometimes|max:255',
        ];
    }

    public function save()
    {

        // check for prevent description field to have only whitespaces
        if (key_exists('description', $this->state) && trim($this->state['description']) == '') {

            $this->state['description'] = null;
        }
        // Validate data inputs
        $validatedData = Validator::make($this->state, $this->rules())->validate();

        // Emit the event to send data to table component
        if ($validatedData) {
            $this->emitTo('build-category-table', 'saveCategory', $validatedData, $this->category->id);
        }
    }
}
