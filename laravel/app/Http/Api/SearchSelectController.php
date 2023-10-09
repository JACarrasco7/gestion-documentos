<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\Build;
use App\Models\BuildCategory;
use App\Models\DocumentTemplate;
use App\Models\Promoter;
use App\Models\Company;
use App\Models\Machine;
use App\Models\User;
use App\Models\Worker;
use DB;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchSelectController extends Controller
{
    public function companies(Request $request): Collection
    {
        return Company::query()
            ->select(DB::raw("companies.`id`,  CONCAT(companies.`name`,' ( ',especialties.name,' )') as name"))
            ->join('especialties', 'especialties.id', '=', 'companies.especialty_id')
            ->orderBy('name')
            ->when(
                $request->exists('build_id'),
                fn(Builder $query) => $query->join('build_company', 'build_company.company_id', '=', 'companies.id')->where('build_company.build_id', $request->input('build_id'))
            )
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('companies.name', 'like', "%{$request->search}%")
                    ->orWhere('cif', 'like', "%{$request->search}%")
                    ->orWhere('especialties.name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('companies.id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(5)
            )
            ->get();
    }

    public function builds(Request $request): Collection
    {

        return Build::query()
            ->select('name', 'id')
            ->where('end_date', '<', date('Y-m-d'))->orWhere('end_date', null)
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(5)
            )
            ->get();
    }

    public function workers(Request $request): Collection
    {
        return Worker::query()
            ->select('id', 'name')
            ->where('company_id', '=', $request->company_id)
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
                    ->orWhere('nif', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(5)
            )
            ->get();
    }

    public function machines(Request $request): Collection
    {
        return Machine::query()
            ->select('id', 'name')
            ->where('company_id', '=', $request->company_id)
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
                    ->orWhere('nif', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(5)
            )
            ->get();
    }

    public function templates(Request $request): Collection
    {
        return DocumentTemplate::query()
            ->select('id', 'name')
            ->where('entity_id', '=', $request->entity_id)
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(5)
            )
            ->get();
    }

    public function promoters(Request $request): Collection
    {
        return Promoter::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(5)
            )
            ->get();
    }

    public function externals(Request $request): Collection
    {
        return User::role('External')
            ->select('id', 'name')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(5)
            )
            ->get();
    }

    public function construction_managers(Request $request): Collection
    {
        return User::role('Construction_manager')
            ->select('id', 'name')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(5)
            )
            ->get();
    }

    public function build_categories(Request $request): Collection
    {
        return BuildCategory::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(5)
            )
            ->get();
    }
}