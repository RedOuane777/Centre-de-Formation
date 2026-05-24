<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seance;
use App\Models\ModuleGroupeEnseignant;
use App\Models\Groupe;
use App\Models\Filiere;
use App\Models\Examen;

class SeanceController extends Controller
{
    public function index()
    {
        $seances = Seance::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe',
            'moduleGroupeEnseignant.enseignant.user'
        ])->get();

        return view('admin.seances.index', compact('seances'));
    }

    public function create()
    {
        $relations = ModuleGroupeEnseignant::with(['module', 'groupe', 'enseignant.user'])
            ->whereNotNull('groupe_id')
            ->get();

        $filieres = Filiere::all();

        return view('admin.seances.create', compact('relations', 'filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module_groupe_enseignant_id' => 'required|exists:module_groupe_enseignants,id',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'salle' => 'required|string|max:50',
        ]);

        Seance::create($request->all());

        return redirect()->route('admin.seances.index')->with('success', 'Séance créée avec succès');
    }

    public function edit($id)
    {
        $seance = Seance::with('moduleGroupeEnseignant')->findOrFail($id);

        $relations = ModuleGroupeEnseignant::with([
            'module',
            'groupe.filiere',
            'enseignant.user'
        ])
            ->whereNotNull('groupe_id')
            ->get();

        $filieres = \App\Models\Filiere::all();

        return view('admin.seances.edit', compact('seance', 'relations', 'filieres'));
    }

    public function update(Request $request, $id)
    {
        $seance = Seance::findOrFail($id);

        $request->validate([
            'module_groupe_enseignant_id' => 'required|exists:module_groupe_enseignants,id',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'salle' => 'required|string|max:50',
        ]);

        $seance->update($request->all());

        return redirect()->route('admin.seances.index')->with('success', 'Séance mise à jour avec succès');
    }

    public function destroy($id)
    {
        Seance::findOrFail($id)->delete();

        return redirect()->route('admin.seances.index')->with('success', 'Séance supprimée avec succès');
    }

    public function destroyAll()
    {
        Seance::truncate();
        return redirect()->route('admin.seances.index')->with('success', 'Toutes les séances ont été supprimées avec succès');
    }

    public function emploi()
    {
        $seances = Seance::with(['moduleGroupeEnseignant.module', 'moduleGroupeEnseignant.groupe', 'moduleGroupeEnseignant.enseignant.user'])->get();

        $examens = Examen::with(['moduleGroupeEnseignant.module', 'moduleGroupeEnseignant.groupe', 'moduleGroupeEnseignant.enseignant.user'])->get();

        $groupes = Groupe::all();
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        $events = collect()
            ->merge($seances->map(function ($s) {
                $s->type = 'seance';
                return $s;
            }))
            ->merge($examens->map(function ($e) {
                $e->type = 'examen';
                $e->typeE = $e->typeE;
                return $e;
            }));

        return view('admin.emploi.index', compact('events', 'groupes', 'jours'));
    }

    public function emploiSearch(Request $request)
    {
        $search = $request->search;

        $groupes = Groupe::query()
            ->when($search, function ($query) use ($search) {
                $query->where('libelle', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            })
            ->get();

        $seances = Seance::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe',
            'moduleGroupeEnseignant.enseignant.user'
        ])->get();

        $examens = Examen::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe',
            'moduleGroupeEnseignant.enseignant.user'
        ])->get();

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        $events = collect()
            ->merge($seances->map(fn($s) => tap($s, fn($x) => $x->type = 'seance')))
            ->merge($examens->map(fn($e) => tap($e, fn($x) => $x->type = 'examen')));

        return view('admin.emploi.index', compact('groupes', 'events', 'jours'));
    }
}
