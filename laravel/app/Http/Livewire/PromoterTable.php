<?php

namespace App\Http\Livewire;

use App\Models\ContactInfo;
use App\Models\Promoter;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns, Responsive};

final class PromoterTable extends PowerGridComponent
{
    use ActionButton;
    public $messages_lang;
    public string $sortField = 'promoters.id';
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'savePromoter',
                'saveModifyPromoter',
                // 'confirmDeletePromoter',
                // 'saveDeletePromoter'
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
            Responsive::make()->fixedColumns('status', 'actions'),
            Header::make()
                ->showSearchInput()
                ->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount()
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
     * @return Builder<\App\Models\Promoter>
     */
    public function datasource(): Builder
    {
        return Promoter::withoutGlobalScopes()
            ->select('promoters.*', 'contact_info.province', 'contact_info.city', 'contact_info.postal_code', 'contact_info.address', 'contact_info.email', 'contact_info.phone_1', 'contact_info.phone_2')
            ->join('contact_info', 'contact_info.id', 'promoters.contact_info_id');
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
            ->addColumn('promoters.id')
            ->addColumn('name')
            ->addColumn('email')
            ->addColumn('phone_1')
            ->addColumn('phone_2')
            // Location visible
            ->addColumn('location', fn ($promoter) => $promoter->getFullAddress())
            // Location filter
            ->addColumn('contact_info.province')
            ->addColumn('contact_info.city')
            ->addColumn('contact_info.postal_code')
            ->addColumn('contact_info.address')
            ->addColumn('contact_name_1')
            ->addColumn('contact_email_1')
            ->addColumn('contact_name_2')
            ->addColumn('contact_email_2')
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
            Column::make('Id', 'promoters.id')->hidden(),
            Column::make(__('Name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('Email'), 'email')
                ->sortable()
                ->searchable(),
            Column::make(__('Phone') . '1', 'phone_1')
                ->sortable()
                ->searchable(),
            Column::make(__('Phone') . '2', 'phone_2')
                ->sortable()
                ->searchable(),
            // Location visible
            Column::make(__('Location'), 'location'),
            // Location filter
            Column::make(__('Province'), 'contact_info.province')->hidden(),
            Column::make(__('City'), 'contact_info.city')->hidden(),
            Column::make(__('Postal code'), 'contact_info.postal_code')->hidden(),
            Column::make(__('Address'), 'contact_info.address')->hidden(),
            // Contact 1
            Column::make(__('Contact name') . '1', 'contact_name_1')
                ->sortable()
                ->searchable(),
            Column::make(__('Contact email') . '1', 'contact_email_1')
                ->sortable()
                ->searchable(),
            // Contact 2
            Column::make(__('Contact name') . '2', 'contact_name_2')
                ->sortable()
                ->searchable(),
            Column::make(__('Contact email') . '2', 'contact_email_2')
                ->sortable()
                ->searchable(),
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
            Filter::inputText('email')->operators(['contains']),
            Filter::inputText('phone_1')->operators(['contains']),
            Filter::inputText('phone_2')->operators(['starts_with']),
            // Location filter
            Filter::inputText('contact_info.province')->operators(['contains']),
            Filter::inputText('contact_info.city')->operators(['contains']),
            Filter::inputText('contact_info.postal_code')->operators(['contains']),
            Filter::inputText('contact_info.address')->operators(['contains']),
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
     * PowerGrid Promoter Action Buttons.
     *
     * @return array<int, Button>
     */

    public function header(): array
    {
        return [
            Button::make('create', __('Create promoter'))
                ->class('Button js-open-button bg-blue-800 cursor-pointer text-white px-3 rounded text-sm leading-10 hover:bg-blue-600')
                ->openModal('promoter-modal', [])->can(auth()->user()->can('Create promoters')),
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
                ->openModal('promoter-modal', ['promoter' => 'id']),

            // Button::add('delete')
            //     ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            //                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            //               </svg>')
            //     ->class('Button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-red-400 hover:text-white active:bg-red-500')
            //     ->emit('confirmDeletePromoter', ['id' => 'id'])
        ];
    }
    public function onUpdatedToggleable(string $id, string $field, string $value): void
    {
        Promoter::withoutGlobalScopes()->find($id)->update([
            $field => $value,
        ]);
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
    public function savePromoter($data, $id = null): void
    {
        if ($id) {
            // Get data contact info for modify
            $data_contactInfo = [
                'province' => $data['province'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'address' => $data['address'],
                'email' => $data['email'],
                'phone_1' => $data['phone_1'],
                'phone_2' => $data['phone_2'],
            ];
            // Modify Promoter and contact info
            $promoter = Promoter::find($id);
            $this->showNotifications('MODIFIED', $promoter->contact_info()->update($data_contactInfo));
            $this->showNotifications('MODIFIED', $promoter->update($data));
        } else {
            // Create promoter and contact info
            $this->showNotifications('CREATED', ContactInfo::create($data)->promoter()->create($data));
        }
    }

    /**
     * Show notification to confirm delete promoter
     *
     */
    // public function confirmDeletePromoter(Promoter $promoter)
    // {
    //     // Get message to show
    //     $message = config('constants.' . $this->messages_lang . '.PROMOTER.DELETED.TITLE_CONFIRM') . '"<b>' . $promoter['name'] . '"<b>';

    //     // Show notification
    //     $this->emit('notificationConfirm', ['table' => 'promoter-table', 'method' => 'saveDeletePromoter', 'text' => $message, 'id' => $promoter->id]);
    // }

    /**
     * Save delete promoter with his contact info, and show notification
     *
     */
    // public function saveDeletePromoter($id)
    // {
    //     $this->showNotifications('DELETED', Promoter::find($id)->delete());
    // }

    /**
     * Show notification according to the insertion status check
     *
     */
    public function showNotifications($action, $status)
    {
        $type_alert = $status ? 'success' : 'error';
        $this->emit('notificationAlert', ['type' => $type_alert, 'title' => config('constants.' . $this->messages_lang . '.PROMOTER.' . $action . '.TITLE'), 'text' => config('constants.' . $this->messages_lang . '.PROMOTER.' . $action . '.TEXT')]);
    }
}
