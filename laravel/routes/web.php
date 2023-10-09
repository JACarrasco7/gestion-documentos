<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'CheckAcceptedConditions'
])->group(function () {


    Route::get('/', function () {
        return view('index', ['table' => 'index']);
    })->name('index');

    // Administrator routes
    Route::group(['middleware' => ['role:Administrator']], function () {

        // Entities
        Route::get('/entidades', function () {
            return view('index', ['table' => 'entity-table']);
        })->name('entities');

        // Users
        Route::get('/usuarios', function () {
            return view('index', ['table' => 'user-table']);
        })->name('users');

        // Promoters
        Route::get('/promotores', function () {
            return view('index', ['table' => 'promoter-table']);
        })->name('promoters');

        // Companies
        Route::get('/empresa', function () {
            return view('index', ['table' => 'company-table']);
        })->name('companies');

        // Machines
        Route::get('/maquinaria', function () {
            return view('index', ['table' => 'machine-table']);
        })->name('machines');

        // build categories
        Route::get('/categorias', function () {
            return view('index', ['table' => 'build-category-table']);
        })->name('categories');

        // Documents Templates
        Route::get('/plantillas', function () {
            return view('index', ['table' => 'template-table']);
        })->name('templates');

        // Documents especialty
        Route::get('/especialidades', function () {
            return view('index', ['table' => 'especialty-table']);
        })->name('especialty');

        // Expiration
        Route::get('/expiraciones', function () {
            return view('index', ['table' => 'document-expiration-type-table']);
        })->name('expirations');

        // Documents templates
        Route::get('/plantilla-documentos', function () {
            return view('index', ['table' => 'document-template-table']);
        })->name('documents-templates');

        // Documents type
        Route::get('/tipos-documentos', function () {
            return view('index', ['table' => 'document-type-table']);
        })->name('documents-types');

        // Documents type
        Route::get('/documentos', function () {
            return view('index', ['table' => 'validate-documents']);
        })->name('documents');
    });

    // Can see workers
    Route::group(['middleware' => ['can:See workers']], function () {

        // Workers
        Route::get('/trabajadores', function () {
            return view('index', ['table' => 'worker-table']);
        })->name('workers');
    });
    Route::group(['middleware' => ['can:Upload documentation']], function () {
        // Upload documents
        Route::get('/documentacion', function () {
            return view('index', ['table' => 'documentation-table']);
        })->name('documentation');
    });


    // Shared routes

    // builds
    Route::get('/obras', function () {
        return view('index', ['table' => 'build-table']);
    })->name('builds');

    // Full view Build
    Route::get('/obra/{id}', function ($id) {
        return view('index', ['table' => 'full-view-build', 'id' => $id]);
    })->name('full-view-build');


    Route::get('set-locale/{locale}', function ($locale) {
        App::setLocale($locale);
        session()->put('locale', $locale);
        Log::debug(config('app.locale'));
        // Artisan::call('optimize:clear');
        return redirect()->back();
    })->middleware('checkLocale')->name('locale.setting');
});
