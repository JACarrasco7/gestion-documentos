<?php

namespace App\Http\Livewire;

use App\Models\Worker;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class WorkerTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;
    public $messages_lang;

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'saveWorker',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->messages_lang = 'MESSAGES_ALERT_' . mb_strtoupper(app()->getLocale());

        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Worker>
     */
    public function datasource(): Builder
    {
        return Worker::where('company_id', Auth::user()->company_id)->withoutGlobalScopes();
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [
            'templates' => [
                'name'
            ]
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')

            /** Example of custom column using a closure **/
            ->addColumn('name_lower', fn (Worker $model) => strtolower(e($model->name)))

            ->addColumn('nif')
            ->addColumn('document_template_id', fn ($worker) => count($worker->templates) > 0 ? $worker->templates->map(fn ($template) => $template->name)->implode(',') : __('No linked templates.'))
            ->addColumn('contact_info_id', fn ($worker) => $worker->getFullAddress())
            ->addColumn('status');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Nif', 'nif')
                ->sortable()
                ->searchable(),

            Column::make(__('Template'), 'document_template_id'),
            Column::make(__('Address'), 'contact_info_id'),
            Column::make('Status', 'status')
                ->toggleable(),


        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            Filter::inputText('name')->operators(['contains']),
            Filter::inputText('nif')->operators(['contains']),
            Filter::boolean('status'),
        ];
    }

    public function onUpdatedToggleable(string $id, string $field, string $value): void
    {
        Worker::withoutGlobalScopes()->find($id)->update([
            $field => $value,
        ]);
    }


    /**
     * PowerGrid Build Action Buttons.
     *
     * @return array<int, Button>
     */

    public function header(): array
    {
        return [
            Button::make('create', __('Create worker'))
                ->class('Button js-open-button bg-blue-800 cursor-pointer text-white px-3 rounded text-sm leading-10 hover:bg-blue-600')
                ->openModal('worker-modal', [])->can(auth()->user()->can('Create workers')),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Worker Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            // Edit build
            Button::add('edit')->tooltip(__('Edit'))
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                   </svg>')
                ->class('Button js-open-button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-amber-400 hover:text-white active:bg-amber-500')
                ->openModal('worker-modal', ['worker' => 'id'])->can(auth()->user()->can('Create workers')),

            //    Button::make('destroy', 'Delete')
            //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            //        ->route('worker.destroy', function(Worker $model) {
            //             return $model->id;
            //        })
            //        ->method('delete')
        ];
    }

    /**
     * Function to save worker
     * @param array $data
     * Array with worker data
     * @param $id
     * If $id param is provided, we must update instead create work
     */
    public function saveWorker($data, $template_id, $id = null): void
    {
        if ($id) {
            // Modify Promoter and contact info
            $worker = Worker::find($id);
            $this->showNotifications('MODIFIED', $worker->update($data));
            $worker->templates()->sync($template_id);
        } else {
            // Create promoter and contact info
            $this->showNotifications('CREATED', \App\Models\ContactInfo::create($data)->worker()->create($data)->sync($template_id));
        }
    }

    /**
     * Show notification according to process.
     *
     */
    public function showNotifications($action, $status): void
    {
        // Show notification according to the insertion check
        $type_alert = $status ? 'success' : 'error';
        $this->emit('notificationAlert', ['type' => $type_alert, 'title' => config('constants.' . $this->messages_lang . '.WORKER.' . $action . '.TITLE'), 'text' => config('constants.' . $this->messages_lang . '.WORKER.' . $action . '.TEXT')]);
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Worker Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($worker) => $worker->id === 1)
                ->hide(),
        ];
    }
    */
}
