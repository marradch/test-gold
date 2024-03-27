<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CountryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReportsController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('countries/list', [CountryController::class, 'list']);
Route::apiResource('countries', CountryController::class);
Route::apiResource('companies', CompanyController::class);
Route::get('generate-minings', [ReportsController::class, 'generateMining']);
Route::get('leaders-report/{month}', [ReportsController::class, 'generateReport']);
