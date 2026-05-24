<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Examen;
use App\Models\Filiere;
use App\Models\ModuleGroupeEnseignant;

class ExamenController extends Controller
{
    public function index(Request $request)
    {
        $query = Examen::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe',
            'moduleGroupeEnseignant.enseignant.user'
        ]);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $terms = explode(' ', $search);

            $query->where(function ($q) use ($terms) {
                foreach ($terms as $term) {
                    $q->where(function ($q2) use ($term) {
                        $q2->whereHas(
                            'moduleGroupeEnseignant.module',
                            fn($q3) =>
                            $q3->where('titre', 'like', "%$term%")
                        )
                            ->orWhereHas(
                                'moduleGroupeEnseignant.groupe',
                                fn($q3) =>
                                $q3->where('libelle', 'like', "%$term%")
                            )
                            ->orWhere('typeE', 'like', "%$term%");
                    });
                }
            });
        }

        $examens = $query->get();

        return view('admin.examens.index', compact('examens'));
    }

    public function create()
    {
        $filieres = \App\Models\Filiere::all();

        $relations = \App\Models\ModuleGroupeEnseignant::with([
            'module',
            'groupe',
            'enseignant.user'
        ])
            ->whereNotNull('groupe_id')
            ->get();

        return view('admin.examens.create', compact('filieres', 'relations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module_groupe_enseignant_id' => 'required|exists:module_groupe_enseignants,id',
            'dateE' => 'required|date',
            'typeE' => 'required|string|max:50',
            'salle' => 'required|string',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ]);

        Examen::create([
            'module_groupe_enseignant_id' => $request->module_groupe_enseignant_id,
            'dateE' => $request->dateE,
            'typeE' => $request->typeE,
            'salle' => $request->salle,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
        ]);

        return redirect()->route('admin.examens.index')
            ->with('success', 'Examen créé avec succès');
    }

    public function edit($id)
    {
        $examen = Examen::findOrFail($id);
        $relations = ModuleGroupeEnseignant::with([
            'module',
            'groupe',
            'enseignant.user'
        ])
            ->whereNotNull('groupe_id')
            ->get();

        $filieres = Filiere::all();

        return view('admin.examens.edit', compact('examen', 'relations', 'filieres'));
    }

    public function update(Request $request, $id)
    {
        $examen = Examen::findOrFail($id);

        $request->validate([
            'module_groupe_enseignant_id' => 'required|exists:module_groupe_enseignants,id',
            'dateE' => 'required|date',
            'typeE' => 'required|string|max:50',
            'salle' => 'required|string',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ]);

        $examen->update([
            'module_groupe_enseignant_id' => $request->module_groupe_enseignant_id,
            'dateE' => $request->dateE,
            'typeE' => $request->typeE,
            'salle' => $request->salle,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
        ]);

        return redirect()->route('admin.examens.index')
            ->with('success', 'Examen mis à jour avec succès');
    }

    public function destroy($id)
    {
        $examen = Examen::findOrFail($id);
        $examen->delete();

        return redirect()->route('admin.examens.index')
            ->with('success', 'Examen supprimé avec succès');
    }

    public function destroyAll()
    {
        Examen::truncate();

        return redirect()->route('admin.examens.index')
            ->with('success', 'Tous les examens ont été supprimés avec succès');
    }

    public function notes()
    {
        $examens = Examen::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe.etudiants.user',
            'moduleGroupeEnseignant.groupe.etudiants.notes',
            'moduleGroupeEnseignant.enseignant.user'
        ])->get();

        return view('admin.notes.index', compact('examens'));
    }
}
