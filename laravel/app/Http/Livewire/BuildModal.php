<?php

namespace App\Http\Livewire;

use App\Models\Build;
use App\Models\BuildCategory;
use App\Models\Promoter;
use App\Models\User;
use App\Rules\phone;
use App\Rules\postal_code;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class BuildModal extends ModalComponent
{
    public Build $build;
    public array $state = [];
    public $insert = true;
    public $category, $promoter, $start_date, $end_date;
    public array $externals = [], $construction_managers = [];

    public function mount()
    {

        try {
            // // Get data Build for Modify
            $this->state = $this->build->toArray();
            $this->state += $this->build->contact_info->toArray();

            // Inputs selected value
            $this->category = $this->build->category_id;
            $this->promoter = $this->build->promoter_id;
            $this->externals = $this->build->external->pluck('id')->toArray();
            $this->construction_managers = $this->build->construction_manager->pluck('id')->toArray();

            // Inputs Date value
            $this->start_date = Carbon::parse($this->build->start_date)->format('d-m-Y');
            $this->end_date = $this->build->end_date ? Carbon::parse($this->build->end_date)->format('d-m-Y') : null;

            // Action
            $this->insert = false;
        } catch (\Throwable $th) {
            // Initialize new Build
            $this->build = new Build;
        }
    }
    public function render()
    {
        return view('livewire.build-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'start_date' => 'required',
            'end_date' => ['sometimes', $this->end_date ? 'after:start_date' : ''],
            'description' => 'sometimes|max:255',
            'category_id' => 'required',
            'promoter_id' => 'required',
            'externals' => 'array',
            'construction_managers' => 'array',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => ['required', new Postal_code],
            'address' => 'required',
            'phone_1' => ['sometimes', new Phone]
        ];
    }

    public function saveBuild()
    {
        $this->state['category_id'] = $this->category;
        $this->state['promoter_id'] = $this->promoter;
        $this->state['externals'] = $this->externals;
        $this->state['construction_managers'] = $this->construction_managers;
        $this->state['start_date'] = Carbon::parse($this->start_date)->format('Y-m-d');
        $this->state['end_date'] = $this->end_date ? Carbon::parse($this->end_date)->format('Y-m-d') : null;

        // Validate data inputs
        $validatedData = Validator::make($this->state, $this->rules())->validate();

        // Emit the event to send data to table component
        if ($validatedData) {
            $this->emitTo('build-table', 'saveBuild', $validatedData, $this->build->id);
        }
    }
}
