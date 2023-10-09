<?php

namespace App\Http\Livewire;

use App\Models\DocumentTemplate;
use App\Models\DocumentType;
use App\Models\Entity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use LivewireUI\Modal\ModalComponent;

class DocumentTemplateModal extends ModalComponent
{

    use WithPagination;
    public DocumentTemplate $document_template;
    public array $state = [];
    public $entity;
    public $filter_search = '';
    public $documents_check = [];
    public $insert = true;
    public $document_types_view;
    public $selectAll = false;

    protected $listeners = ['resetDocumentsCheck'];


    public function mount()
    {
        try {
            $this->state = $this->document_template->toArray();
            $this->entity = $this->document_template->entity->id;
            $this->documents_check = $this->document_template->document_type->mapWithkeys(fn($doc) => [$doc->id => $doc->id])->toArray();
            $this->insert = false;
        } catch (\Throwable $th) {
            $this->document_template = new DocumentTemplate;
        }
    }
    public function render()
    {
        $query = DocumentType::where('entity_id', $this->entity)
            ->where('name', 'like', '%' . $this->filter_search . '%')
            ->orWhere('description', 'like', '%' . $this->filter_search . '%')
            ->where('entity_id', $this->entity);

        $this->document_types_view = $query->pluck('id');

        return view('livewire.document-template-modal', [
            'document_types' => $query->paginate(4)
        ]);
    }
    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'description' => 'sometimes|max:255',
            'entity_id' => 'required',
            'documents_check' => 'array|required'
        ];
    }

    public function save()
    {

        // Get select value
        $this->state['entity_id'] = $this->entity;

        $this->state['documents_check'] = $this->documents_check;
        // check for prevent description field to have only whitespaces
        if (key_exists('description', $this->state) && trim($this->state['description']) == '') {
            $this->state['description'] = null;
        }

        // Validate data inputs
        $validatedData = Validator::make($this->state, $this->rules())->validate();
        // Emit the event to send data to table component
        if ($validatedData) {
            $this->emitTo('document-template-table', 'saveDocumentTemplate', $validatedData, $this->document_template->id);
        }
    }


    public function updatingEntity($selectedEntity)
    {
        if ($selectedEntity != $this->entity) {
            $this->documents_check = [];
        }
    }

    public function checkDocument($document_id)
    {

        if (array_key_exists($document_id, $this->documents_check)) {
            unset($this->documents_check[$document_id]);
        } else {
            $this->documents_check[$document_id] = $document_id;
        }
    }

    public function getEntities()
    {
        return Entity::all();
    }

    public function updatingSelectAll($value)
    {
        foreach ($this->document_types_view as $doc) {
            if (!$value) {
                $this->documents_check = [];
            } else {
                $this->documents_check[$doc] = $doc;
            }
        }
    }
}
