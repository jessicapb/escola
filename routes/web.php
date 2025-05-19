<?php
use App\Models\Modul;
use App\Models\Professor;
use App\Models\Alumnes;
use App\Models\UnitatsFormatives;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $moduls = Modul::all();
    return view('home', compact('moduls'));
});

Route::get('/moduls', function () {
    $moduls = \App\Models\Modul::all();
    return view('moduls', compact('moduls'));
});

Route::get('/professor', function () {
    $professor = \App\Models\Professor::all();
    return view('professor', compact('professor'));
});

Route::get('/alumnes', function () {
    $alumnes = \App\Models\Alumnes::all();
    return view('alumnes', compact('alumnes'));
});

Route::get('/unitatsformatives', function () {
    $unitatsformatives = \App\Models\UnitatsFormatives::all();
    return view('unitatsformatives', compact('unitatsformatives'));
});

