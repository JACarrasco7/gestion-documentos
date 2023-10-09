<?php

namespace App\Http\Livewire;

use App\Models\Especialty;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class EspecialtyTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public $messages_lang;

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'saveEspecialty',
                'confirmDeleteEspecialty',
                'saveDeleteEspecialty'
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
     * @return Builder<\App\Models\Especialty>
     */
    public function datasource(): Builder
    {
        return Especialty::query();
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
        return [];
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
            // ->addColumn('id')
            ->addColumn('name')
            ->addColumn('description');
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
            // Column::make('Id', 'id'),
            Column::make(__('Name'), 'name')
                ->sortable()
                ->searchable(),

            Column::make(__('Description'), 'description')
                ->sortable()
                ->searchable(),


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
        ];
    }

    /**
     * PowerGrid User Action Buttons.
     *
     * @return array<int, Button>
     */

    public function header(): array
    {
        return [
            Button::make('create_especialty', __('Create especialty'))
                ->class('Button js-open-button bg-blue-800 cursor-pointer text-white px-3 rounded text-sm leading-10 hover:bg-blue-600')
                ->openModal('especialty-modal', [])->can(auth()->user()->can('Create company')),
        ];
    }

    public function actions(): array
    {
        return [
            Button::add('edit')
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                         </svg>')
                ->class('Button js-open-button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-amber-400 hover:text-white active:bg-amber-500')
                ->openModal('especialty-modal', ['especialty' => 'id']),

            Button::add('delete')
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                          </svg>')
                ->class('Button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-red-400 hover:text-white active:bg-red-500')
                ->emit('confirmDeleteEspecialty', ['id' => 'id'])
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
     * PowerGrid Especialty Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('especialty.edit', function(\App\Models\Especialty $model) {
                    return $model->id;
               }),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('especialty.destroy', function(\App\Models\Especialty $model) {
                    return $model->id;
               })
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Especialty Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($especialty) => $especialty->id === 1)
                ->hide(),
        ];
    }
    */

    /**
     * Function to save the category
     * @param array $data
     * Array with category data
     * @param $id
     * If $id param is provided, we must update instead create category
     */
    public function saveEspecialty($data, $id = null)
    {
        $id ? $this->showAlerts('MODIFIED', Especialty::find($id)->update($data)) : $this->showAlerts('CREATED', Especialty::create($data));
    }

    /**
     * Function to emit the show alert event in order to display
     * sweetalert modal
     */

    public function showAlerts($action, $status)
    {
        // Show notification according to the insertion check
        $type_alert = $status ? 'success' : 'error';
        $this->emit('notificationAlert', ['type' => $type_alert, 'title' => config('constants.' . $this->messages_lang . '.ESPECIALTY.' . $action . '.TITLE'), 'text' => config('constants.' . $this->messages_lang . '.ESPECIALTY.' . $action . '.TEXT')]);
    }

    public function confirmDeleteEspecialty(Especialty $especialty)
    {
        $message = config('constants.' . $this->messages_lang . '.ESPECIALTY.DELETED.TITLE_CONFIRM') . '"<b>' . $especialty->name . '"<b>';
        $this->emit('notificationConfirm', ['table' => 'especialty-table', 'method' => 'saveDeleteEspecialty', 'text' => $message, 'id' => $especialty->id]);
    }

    public function saveDeleteEspecialty(Especialty $especialty)
    {
        $this->showAlerts('DELETED', $especialty->delete());
    }
}
