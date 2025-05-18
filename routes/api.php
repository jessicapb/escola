<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\AlumnesController;
use App\Http\Controllers\UnitatsFormativesController;

Route::apiResource('moduls', ModulController::class);
Route::apiResource('professor', ProfessorController::class);
Route::apiResource('alumnes', AlumnesController::class);
Route::apiResource('unitatsformatives', UnitatsFormativesController::class);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
