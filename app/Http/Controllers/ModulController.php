<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;

class ModulController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        if ($q) {
            return Modul::where('nom', 'like', "%$q%")->get();
        }
        return Modul::all();
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'descripcio' => 'required|string|max:255',
        ]);
    
        $modul = Modul::create($request->only('nom', 'descripcio'));
    
        return response()->json($modul, 201);
    }
    

    public function show(Modul $modul)
    {
        return $modul;
    }

    public function update(Request $request, Modul $modul)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'descripcio' => 'required|string|max:255',
        ]);
    
        $modul->update($request->only('nom', 'descripcio'));
    
        return response()->json($modul);
    }
    

    public function destroy(Modul $modul)
    {
        $modul->delete();

        return response()->json(null, 204);
    }
}
