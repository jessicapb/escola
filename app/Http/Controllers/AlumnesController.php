<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumnes;

class AlumnesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        if ($q) {
            return Alumnes::where('nom', 'like', "%$q%")->get();
        }
        return Alumnes::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
        ]);
    
        $alumne = Alumnes::create($request->only('nom', 'cognoms'));
    
        return response()->json($alumne, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumnes $alumne)
    {
        return $alumne;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumnes $alumnes)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
        ]);
    
        $alumnes->update($request->only('nom', 'cognoms'));
    
        return response()->json($alumnes);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alumne = Alumnes::find($id);
        if (!$alumne) {
            return response()->json(['message' => 'Alumne no trobat'], 404);
        }
        $alumne->delete();
        return response()->json(null, 204);
    }
}
