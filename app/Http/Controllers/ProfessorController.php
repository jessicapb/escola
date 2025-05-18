<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        if ($q) {
            return Professor::where('nom', 'like', "%$q%")->get();
        }
        return Professor::all();
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
    
        $professor = Professor::create($request->only('nom', 'cognoms'));
    
        return response()->json($professor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Professor $professor)
    {
        return $professor;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Professor $professor)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
        ]);
    
        $professor->update($request->only('nom', 'cognoms'));
    
        return response()->json($professor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professor $professor)
    {
        $professor->delete();

        return response()->json(null, 204);
    }
}
