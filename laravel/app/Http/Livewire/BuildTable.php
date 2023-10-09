<?php

namespace App\Http\Livewire;

use App\Models\Build;
use App\Models\BuildCategory;
use App\Models\ContactInfo;
use App\Models\Promoter;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns, Responsive};

final class BuildTable extends PowerGridComponent
{
    use ActionButton;

    public $messages_lang;
    public string $sortField = 'builds.id';

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'saveBuild',
                'assignCompany',
                'assignWorker',
                'assignMachine',
                'uploadDocument'
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
     * @return Builder<\App\Models\Build>
     */
    public function datasource(): Builder
    {
        switch (auth()->user()->roles()->first()->id) {
                // Company
            case config('constants.ROLES.COMPANY.ID'):
                return Build::query()
                    ->select(
                        'builds.*',
                        'contact_info.province',
                        'contact_info.city',
                        'contact_info.postal_code',
                        'contact_info.address',
                        'contact_info.email',
                        'contact_info.phone_1',
                        'contact_info.phone_2'
                    )
                    ->join('contact_info', 'contact_info.id', 'builds.contact_info_id')
                    ->join('build_company', 'build_company.build_id', '=', 'builds.id')->where('build_company.company_id', auth()->user()->company->id);
                // Admin
            default:
                return Build::query()
                    ->select(
                        'builds.*',
                        'contact_info.province',
                        'contact_info.city',
                        'contact_info.postal_code',
                        'contact_info.address',
                        'contact_info.email',
                        'contact_info.phone_1',
                        'contact_info.phone_2'
                    )
                    ->join('contact_info', 'contact_info.id', 'builds.contact_info_id');
        }
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
            ->addColumn('start_date_formatted', fn (Build $build) => Carbon::parse($build->start_date)->format('d/m/Y'))
            ->addColumn('end_date_formatted', fn (Build $build) => $build->end_date ? Carbon::parse($build->end_date)->format('d/m/Y') : __('In construction'))
            ->addColumn('category', fn ($build) => $build->category ? $build->category->name : __('Relation not defined.'))
            ->addColumn('promoter', fn ($build) => $build->promoter ? $build->promoter->name : __('Relation not defined.'))
            ->addColumn('external', function (Build $build) {
                $externals = "";
                if (!empty($build)) {
                    foreach ($build->externals as $external) {
                        $externals .= $external->name . ' ,';
                    }
                    return rtrim($externals, ',');
                } else {
                    return __('Relation not defined.');
                }
            })
            ->addColumn('construction_manager', function (Build $build) {
                $construction_managers = "";
                if (!empty($build)) {
                    foreach ($build->construction_managers as $construction_manager) {
                        $construction_managers .= $construction_manager->name . ' ,';
                    }
                    return rtrim($construction_managers, ',');
                } else {
                    return __('Relation not defined.');
                }
            })
            // Location visible
            ->addColumn('location', fn ($build) => $build->getFullAddress())
            // Location filter
            ->addColumn('contact_info.province')
            ->addColumn('contact_info.city')
            ->addColumn('contact_info.postal_code')
            ->addColumn('contact_info.address')
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
            Column::make('Id', 'id')->hidden(),
            Column::make(__('Name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('Start date'), 'start_date_formatted', 'start_date')
                ->sortable(),
            Column::make(__('End date'), 'end_date_formatted', 'end_date')
                ->sortable(),
            Column::make(__('Category'), 'category'),
            Column::make(__('Promoter'), 'promoter'),
            Column::make(__('External'), 'external'),
            Column::make(__('Constructio manager'), 'construction_manager'),
            // Location visible
            Column::make(__('Location'), 'location'),
            // Location filter
            Column::make(__('Province'), 'contact_info.province')->hidden(),
            Column::make(__('City'), 'contact_info.city')->hidden(),
            Column::make(__('Postal code'), 'contact_info.postal_code')->hidden(),
            Column::make(__('Address'), 'contact_info.address')->hidden(),
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
            Filter::datepicker('start_date'),
            Filter::datepicker('end_date'),
            Filter::boolean('end_date')->label(__('Finished'), __('Not finished')),
            Filter::select('category', 'category_id')->dataSource(BuildCategory::all())->optionLabel('name')->optionValue('id'),
            Filter::select('promoter', 'promoter_id')->dataSource(Promoter::all())->optionLabel('name')->optionValue('id'),
            Filter::select('external', 'external_id')->dataSource(User::all())->optionLabel('name')->optionValue('id'),
            // Location filter
            Filter::inputText('contact_info.province')->operators(['contains']),
            Filter::inputText('contact_info.city')->operators(['contains']),
            Filter::inputText('contact_info.postal_code')->operators(['contains']),
            Filter::inputText('contact_info.address')->operators(['contains']),
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
     * PowerGrid Build Action Buttons.
     *
     * @return array<int, Button>
     */

    public function header(): array
    {
        return [
            Button::make('create', __('Create build'))
                ->class('Button js-open-button bg-blue-800 cursor-pointer text-white px-3 rounded text-sm leading-10 hover:bg-blue-600')
                ->openModal('build-modal', [])->can(auth()->user()->can('Create work')),
        ];
    }

    public function actions(): array
    {
        return [
            // Upload documents
            Button::add('upload-documents')->tooltip(__('Upload documents'))
                ->caption('<svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5535 2.49392C12.4114 2.33852 12.2106 2.25 12 2.25C11.7894 2.25 11.5886 2.33852 11.4465 2.49392L7.44648 6.86892C7.16698 7.17462 7.18822 7.64902 7.49392 7.92852C7.79963 8.20802 8.27402 8.18678 8.55352 7.88108L11.25 4.9318V16C11.25 16.4142 11.5858 16.75 12 16.75C12.4142 16.75 12.75 16.4142 12.75 16V4.9318L15.4465 7.88108C15.726 8.18678 16.2004 8.20802 16.5061 7.92852C16.8118 7.64902 16.833 7.17462 16.5535 6.86892L12.5535 2.49392Z"/>
                        <path d="M3.75 15C3.75 14.5858 3.41422 14.25 3 14.25C2.58579 14.25 2.25 14.5858 2.25 15V15.0549C2.24998 16.4225 2.24996 17.5248 2.36652 18.3918C2.48754 19.2919 2.74643 20.0497 3.34835 20.6516C3.95027 21.2536 4.70814 21.5125 5.60825 21.6335C6.47522 21.75 7.57754 21.75 8.94513 21.75H15.0549C16.4225 21.75 17.5248 21.75 18.3918 21.6335C19.2919 21.5125 20.0497 21.2536 20.6517 20.6516C21.2536 20.0497 21.5125 19.2919 21.6335 18.3918C21.75 17.5248 21.75 16.4225 21.75 15.0549V15C21.75 14.5858 21.4142 14.25 21 14.25C20.5858 14.25 20.25 14.5858 20.25 15C20.25 16.4354 20.2484 17.4365 20.1469 18.1919C20.0482 18.9257 19.8678 19.3142 19.591 19.591C19.3142 19.8678 18.9257 20.0482 18.1919 20.1469C17.4365 20.2484 16.4354 20.25 15 20.25H9C7.56459 20.25 6.56347 20.2484 5.80812 20.1469C5.07435 20.0482 4.68577 19.8678 4.40901 19.591C4.13225 19.3142 3.9518 18.9257 3.85315 18.1919C3.75159 17.4365 3.75 16.4354 3.75 15Z"/>
                        </svg>')
                ->class('Button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-sky-400 hover:text-white active:bg-sky-500')
                ->openModal('upload-document-modal', ['build' => 'id'])->can(auth()->user()->roles()->first()->id == config('constants.ROLES.COMPANY.ID')),

            // Add worker to build
            Button::add('add-worker')->tooltip(__('Add worker'))
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
          </svg>
          ')
                ->class('Button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-lime-400 hover:text-white active:bg-lime-500')
                ->openModal('add-worker-modal', ['build' => 'id'])->can(auth()->user()->roles()->first()->id == config('constants.ROLES.COMPANY.ID')),

            // Add machine to build
            Button::add('add-machine')->tooltip(__('Add machine'))
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
              </svg>
              ')
                ->class('Button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-lime-400 hover:text-white active:bg-lime-500')
                ->openModal('add-machine-modal', ['build' => 'id'])->can(auth()->user()->roles()->first()->id == config('constants.ROLES.COMPANY.ID')),

            // Add company
            Button::add('add-company')->tooltip(__('Add company'))
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
             <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
             </svg>')
                ->class('Button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-lime-400 hover:text-white active:bg-lime-500')
                ->openModal('add-company-modal', ['build' => 'id'])->can(auth()->user()->can('Create work')),


            // View build
            Button::add('view')->tooltip(__('View details'))
                ->caption('<svg viewBox="0 0 24 24" fill="currentColor" stroke-width="0" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" stroke="currentColor">
                            <path fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" clip-rule="evenodd" d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25ZM9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z"/>
                            <path fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" clip-rule="evenodd" d="M12 3.25C7.48587 3.25 4.44529 5.9542 2.68057 8.24686L2.64874 8.2882C2.24964 8.80653 1.88206 9.28392 1.63269 9.8484C1.36564 10.4529 1.25 11.1117 1.25 12C1.25 12.8883 1.36564 13.5471 1.63269 14.1516C1.88206 14.7161 2.24964 15.1935 2.64875 15.7118L2.68057 15.7531C4.44529 18.0458 7.48587 20.75 12 20.75C16.5141 20.75 19.5547 18.0458 21.3194 15.7531L21.3512 15.7118C21.7504 15.1935 22.1179 14.7161 22.3673 14.1516C22.6344 13.5471 22.75 12.8883 22.75 12C22.75 11.1117 22.6344 10.4529 22.3673 9.8484C22.1179 9.28391 21.7504 8.80652 21.3512 8.28818L21.3194 8.24686C19.5547 5.9542 16.5141 3.25 12 3.25ZM3.86922 9.1618C5.49864 7.04492 8.15036 4.75 12 4.75C15.8496 4.75 18.5014 7.04492 20.1308 9.1618C20.5694 9.73159 20.8263 10.0721 20.9952 10.4545C21.1532 10.812 21.25 11.2489 21.25 12C21.25 12.7511 21.1532 13.188 20.9952 13.5455C20.8263 13.9279 20.5694 14.2684 20.1308 14.8382C18.5014 16.9551 15.8496 19.25 12 19.25C8.15036 19.25 5.49864 16.9551 3.86922 14.8382C3.43064 14.2684 3.17374 13.9279 3.00476 13.5455C2.84684 13.188 2.75 12.7511 2.75 12C2.75 11.2489 2.84684 10.812 3.00476 10.4545C3.17374 10.0721 3.43063 9.73159 3.86922 9.1618Z"/>
                            </svg>')
                ->class('Button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-indigo-400 hover:text-white active:bg-indigo-500')
                ->openModal('view-build-modal', ['build' => 'id'])->can(auth()->user()->can('See work')),

            // Edit build
            Button::add('edit')->tooltip(__('Edit'))
                ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                         </svg>')
                ->class('Button js-open-button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-amber-400 hover:text-white active:bg-amber-500')
                ->openModal('build-modal', ['build' => 'id'])->can(auth()->user()->can('Create work')),

            // Button::add('delete')
            //     ->caption('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            //                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            //               </svg>')
            //     ->class('Button cursor-pointer px-3 py-2 m-1 rounded text-sm hover:bg-red-400 hover:text-white active:bg-red-500')
            //     ->emit('confirmDeleteBuild', ['build' => 'id'])
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Build Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($build) => $build->id === 1)
                ->hide(),
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Custom develop
    |--------------------------------------------------------------------------
    |  All function make for custom develop.
    |
    */

    /**
     * Function to save Build
     * @param array $data
     * Array with Build data
     * @param $id
     * If $id param is provided, we must update instead create Build
     */
    public function saveBuild($data, $id = null): void
    {

        if ($id) {
            // Get data contact info for modify
            $data_contactInfo = [
                'province' => $data['province'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'address' => $data['address'],
                'phone_1' => $data['phone_1'],
            ];
            // Modify Promoter and contact info
            $build = Build::find($id);
            $build->externals()->sync($data['externals']);
            $build->construction_managers()->sync($data['construction_managers']);
            $this->showNotifications('MODIFIED', $build->contact_info()->update($data_contactInfo));
            $this->showNotifications('MODIFIED', $build->update($data));
        } else {
            // Create promoter and contact info
            $this->showNotifications('CREATED', $build = ContactInfo::create($data)->build()->create($data));
            $build->externals()->sync($data['externals']);
            $build->construction_managers()->sync($data['construction_managers']);
        }
    }

    /**
     * Assign company/s to the build
     */
    public function assignCompany(array $companies, Build $build)
    {
        $build->companies()->sync($companies);
        if (!$build->createDirectories()) {
            $this->showNotifications('ERROR', false);
            return;
        }
        $this->showNotifications('COMPANY', true);
    }

    /**
     * Assign worker/s to given build
     * @param Build $build
     * @param array $worker_ids
     */

    public function assignWorker(Build $build, array $worker_ids)
    {
        // Assign workers to the build
        $build->workers()->sync($worker_ids);

        // Create folder structure
        if (!$build->createDirectories()) {
            $this->showNotifications('ERROR', false);
            return;
        }

        $this->showNotifications('COMPANY', true);
    }

    /**
     * Assign machines/s to given build
     * @param Build $build
     * @param array $machine_ids
     */

    public function assignMachine(Build $build, array $machine_ids)
    {
        // Assign workers to the build
        $build->machines()->sync($machine_ids);

        // Create folder structure
        if (!$build->createDirectories()) {
            $this->showNotifications('ERROR', false);
            return;
        }

        $this->showNotifications('MACHINES', true);
    }

    /**
     * Show notification according to process.
     *
     */
    public function showNotifications($action, $status): void
    {
        // Show notification according to the insertion check
        $type_alert = $status ? 'success' : 'error';
        $this->emit('notificationAlert', ['type' => $type_alert, 'title' => config('constants.' . $this->messages_lang . '.BUILD.' . $action . '.TITLE'), 'text' => config('constants.' . $this->messages_lang . '.BUILD.' . $action . '.TEXT')]);
    }
}
