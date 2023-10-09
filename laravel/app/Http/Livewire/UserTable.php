<?php

namespace App\Http\Livewire;

use App\Http\Helpers\Helpers;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns, Responsive};

final class UserTable extends PowerGridComponent
{
    use ActionButton;
    public $messages_lang;

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'saveUser',
                'confirmDeleteUser',
                'saveDeleteUser',
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
        // Choose messages according to the languague app
        $this->messages_lang = 'MESSAGES_ALERT_' . mb_strtoupper(app()->getLocale());
        return [
            Responsive::make()->fixedColumns('status', 'accepted_condition', 'actions'),
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
     * @return Builder<\App\Models\User>
     */
    public function datasource(): Builder
    {
        return User::withoutGlobalScopes();
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
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('username')
            ->addColumn('email')
            ->addColumn('role', function (User $user) {
                return __(str_replace('_', ' ', $user->getRoleNames()[0]));
            })
            ->addColumn('accepted_condition')
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
            Column::make('Id', 'id')->hidden(),
            Column::make(__('Name'), 'name')
                ->sortable()
                ->searchable(),

            Column::make(__('Username'), 'username')
                ->sortable()
                ->searchable(),

            Column::make(__('Email'), 'email')
                ->sortable()
                ->searchable(),

            Column::make(__('Role'), 'role')
                ->sortable()
                ->searchable(),

            Column::make(__('Accepted conditions'), 'accepted_condition')
                ->toggleable(false),

            Column::make(__('Status'), 'status')
                ->toggleable(true),

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
            Filter::inputText('username')->operators(['contains']),
            Filter::inputText('email')->operators(['contains']),
            Filter::select('role', 'id')->dataSource(Helpers::getRolesName())->optionLabel('name')->optionValue('id'),
            Filter::boolean('status')->label(__('Active'), __('Inactive')),
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
     * PowerGrid User Action Buttons.
     *
     * @return array<int, Button>
     */

    public function header(): array
    {
        return [
            Button::make('create', __('Create user'))
                ->class('bg-blue-800 cursor-pointer text-white px-3 rounded text-sm leading-10 hover:bg-blue-600')
                ->openModal('user-modal', [])->can(auth()->user()->can('Create users')),
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
                ->openModal('user-modal', ['user' => 'id']),

            Button::add('delete')
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                         </svg>')
                ->class('Button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-red-400 hover:text-white active:bg-red-500')
                ->emit('confirmDeleteUser', ['id' => 'id'])
        ];
    }

    public function onUpdatedToggleable(string $id, string $field, string $value): void
    {
        if (auth()->user()->id != $id)
            User::withoutGlobalScopes()->find($id)->update([
                $field => $value,
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid User Action Rules.
     *
     * @return array<int, RuleActions>
     */


    public function actionRules(): array
    {
        return [
            //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn ($user) => $user->id === 1)
                ->hide(),
            Rule::button('delete')
                ->when(fn ($user) => $user->id === 1 || $user->id === Auth::user()->id)
                ->hide(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Custom develop
    |--------------------------------------------------------------------------
    |  All function make for custom develop.
    |
    */

    /**
     * Function to save User
     * @param array $data
     * Array with User data
     * @param $id
     * If $id param is provided, we must update instead create User
     */
    public function saveUser($data, $id = null): void
    {
        // If isset id check the role for assign new role or not
        if ($id) {

            // Find the user for modify
            $user = User::find($id);

            // Check if there is a need to change role
            if (isset($data['currentRole_user']) && ($data['selectRole_user'] != $data['currentRole_user'])) {

                // Remove old role
                $user->removeRole($data['currentRole_user']);

                // Assign new role
                $user->assignRole($data['selectRole_user']);
            }
        }

        // Save User data and show notification
        $id ? $this->showNotifications('MODIFIED', $user->update($data)) : $this->showNotifications('CREATED', User::create($data)->assignRole($data['selectRole_user']));
    }

    /**
     * Confirm delete user
     *
     */
    public function confirmDeleteUser(User $user)
    {
        $message = config('constants.' . $this->messages_lang . '.USER.DELETED.TITLE_CONFIRM') . '"<b>' . $user['username'] . '"<b>';
        $this->emit('notificationConfirm', ['table' => 'user-table', 'method' => 'saveDeleteUser', 'text' => $message, 'id' => $user->id]);
    }

    /**
     * Function to save delete user
     *
     */
    public function saveDeleteUser($id)
    {
        $this->showNotifications('DELETED', User::find($id)->delete());
    }

    /**
     * Function to emit notification according to process.
     *
     */
    public function showNotifications($action, $status)
    {
        // Show notification according to the insertion check
        $type_alert = $status ? 'success' : 'error';
        $this->emit('notificationAlert', ['type' => $type_alert, 'title' => config('constants.' . $this->messages_lang . '.USER.' . $action . '.TITLE'), 'text' => config('constants.' . $this->messages_lang . '.USER.' . $action . '.TEXT')]);
    }
}
