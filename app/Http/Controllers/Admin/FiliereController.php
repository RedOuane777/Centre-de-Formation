<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filiere;

class FiliereController extends Controller
{
    public function index(Request $request)
    {
        $query = Filiere::query();

        if ($request->search) {
            $search = $request->search;

            $query->where('libelle', 'like', "%{$search}%");
        }

        $filieres = $query->get();

        return view('admin.filieres.index', compact('filieres'));
    }

    public function create()
    {
        return view('admin.filieres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        Filiere::create([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('admin.filieres.index')->with('success', 'Filière créé avec succès');
    }

    public function edit($id)
    {
        $filiere = Filiere::findOrFail($id);
        return view('admin.filieres.edit', compact('filiere'));
    }

    public function update(Request $request, $id)
    {
        $filiere = Filiere::findOrFail($id);

        $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        $filiere->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('admin.filieres.index')->with('success', 'Filière mise à jour avec succès');
    }

    public function destroy($id)
    {
        $filiere = Filiere::findOrFail($id);
        $filiere->delete();

        return redirect()->route('admin.filieres.index')->with('success', 'Filière supprimée avec succès');
    }

    public function destroyAll()
    {
        $filieres = Filiere::all();

        foreach ($filieres as $filiere) {
            $filiere->delete();
        }

        return redirect()->route('admin.filieres.index')
            ->with('success', 'Tous les filières ont été supprimés avec succès');
    }
}