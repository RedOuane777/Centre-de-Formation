<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Models\Filiere;

class GroupeController extends Controller
{
    public function index(Request $request)
    {
        $query = Groupe::with('filiere', 'etudiants.user');

        if ($request->search) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('libelle', 'like', "%{$search}%")
                ->orWhereHas('filiere', function($q2) use ($search) {
                    $q2->where('libelle', 'like', "%{$search}%");
                });
            });
        }

        $groupes = $query->get();

        return view('admin.groupes.index', compact('groupes'));
    }

    public function create()
    {
        $filieres = Filiere::all();
        return view('admin.groupes.create', compact('filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        Groupe::create([
            'libelle' => $request->libelle,
            'filiere_id' => $request->filiere_id,
        ]);

        return redirect()->route('admin.groupes.index')->with('success', 'Groupe créé avec succès');
    }

    public function edit($id)
    {
        $groupe = Groupe::findOrFail($id);
        $filieres = Filiere::all();
        return view('admin.groupes.edit', compact('groupe', 'filieres'));
    }

    public function update(Request $request, $id)
    {
        $groupe = Groupe::findOrFail($id);

        $request->validate([
            'libelle' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $groupe->update([
            'libelle' => $request->libelle,
            'filiere_id' => $request->filiere_id,
        ]);

        return redirect()->route('admin.groupes.index')->with('success', 'Groupe mis à jour avec succès');
    }

    public function destroy($id)
    {
        $groupe = Groupe::findOrFail($id);
        $groupe->delete();

        return redirect()->route('admin.groupes.index')->with('success', 'Groupe supprimé avec succès');
    }

    public function destroyAll()
    {
        $groupes = Groupe::all();

        foreach ($groupes as $groupe) {
            $groupe->delete();
        }

        return redirect()->route('admin.groupes.index')
            ->with('success', 'Tous les groupes ont été supprimés avec succès');
    }
}