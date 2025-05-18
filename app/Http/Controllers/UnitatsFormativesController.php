<?php

namespace App\Http\Controllers;

use App\Models\UnitatsFormatives;
use Illuminate\Http\Request;

class UnitatsFormativesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        if ($q) {
            return UnitatsFormatives::where('nom', 'like', "%$q%")->get();
        }
        return UnitatsFormatives::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'descripcio' => 'required|string|max:255',
        ]);
    
        $unitatsformatives = UnitatsFormatives::create($request->only('nom', 'descripcio'));
    
        return response()->json($unitatsformatives, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitatsFormatives $unitatsformatives)
    {
        return $unitatsformatives;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitatsFormatives $unitatsformatives)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'descripcio' => 'required|string|max:255',
        ]);
    
        $unitatsformatives->update($request->only('nom', 'descripcio'));
    
        return response()->json($unitatsformatives);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unitatsformatives = UnitatsFormatives::find($id);
        if (!$unitatsformatives) {
            return response()->json(['message' => 'Unitat Formativa no trobada'], 404);
        }
        $unitatsformatives->delete();
        return response()->json(null, 204);
    }
}
