<?php

use App\Http\Api\SearchSelectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Get all companies
Route::get('/companies', [SearchSelectController::class, 'companies'])->name('search.companies');
Route::get('/builds', [SearchSelectController::class, 'builds'])->name('search.builds');
Route::get('/workers', [SearchSelectController::class, 'workers'])->name('search.workers');
Route::get('/machines', [SearchSelectController::class, 'machines'])->name('search.machines');
Route::get('/templates', [SearchSelectController::class, 'templates'])->name('search.templates');
Route::get('/promoters', [SearchSelectController::class, 'promoters'])->name('search.promoters');
Route::get('/external', [SearchSelectController::class, 'externals'])->name('search.externals');
Route::get('/build-categories', [SearchSelectController::class, 'build_categories'])->name('search.build_categories');
Route::get('/construction-managers', [SearchSelectController::class, 'construction_managers'])->name('search.construction_managers');
