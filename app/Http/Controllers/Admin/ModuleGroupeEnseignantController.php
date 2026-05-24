<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModuleGroupeEnseignant;
use App\Models\Module;
use App\Models\Enseignant;

class ModuleGroupeEnseignantController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $relations = ModuleGroupeEnseignant::with(['module', 'groupe', 'enseignant.user'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('module', function ($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%");
                })
                    ->orWhereHas('groupe', function ($q) use ($search) {
                        $q->where('libelle', 'like', "%{$search}%");
                    })
                    ->orWhereHas('enseignant.user', function ($q) use ($search) {
                        $q->where('nom', 'like', "%{$search}%")
                            ->orWhere('prenom', 'like', "%{$search}%");
                    });
            })
            ->get();

        return view('admin.mge.index', compact('relations'));
    }

    public function create()
    {
        $modules = Module::all();
        $enseignants = Enseignant::with('user')->get();

        return view('admin.mge.create', compact('modules', 'enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required',
            'groupe_id' => 'required',
            'enseignant_id' => 'required',
        ]);

        $exists = ModuleGroupeEnseignant::where([
            'module_id' => $request->module_id,
            'groupe_id' => $request->groupe_id,
            'enseignant_id' => $request->enseignant_id,
        ])->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Cette relation existe déjà !');
        }

        ModuleGroupeEnseignant::create([
            'module_id' => $request->module_id,
            'groupe_id' => $request->groupe_id,
            'enseignant_id' => $request->enseignant_id,
        ]);

        return redirect()->route('admin.mge.index')
            ->with('success', 'Relation ajoutée avec succès');
    }

    public function edit($id)
    {
        $relation = ModuleGroupeEnseignant::findOrFail($id);

        return view('admin.mge.edit', compact('relation'));
    }

    public function update(Request $request, $id)
    {
        $relation = ModuleGroupeEnseignant::findOrFail($id);

        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'groupe_id' => 'required|exists:groupes,id',
            'enseignant_id' => 'required|exists:enseignants,id',
        ]);

        $relation->update([
            'module_id' => $request->module_id,
            'groupe_id' => $request->groupe_id,
            'enseignant_id' => $request->enseignant_id,
        ]);

        return redirect()->route('admin.mge.index')
            ->with('success', 'Relation mise à jour avec succès.');
    }

    public function enseignants($id, Request $request)
    {
        $groupeId = $request->query('groupe_id');

        $enseignants = ModuleGroupeEnseignant::with('enseignant.user')
            ->where('module_id', $id)
            ->when($groupeId, function ($q) use ($groupeId) {
                $q->where('groupe_id', $groupeId);
            })
            ->get()
            ->pluck('enseignant')
            ->unique('id')
            ->values();

        return response()->json(
            $enseignants->map(function ($e) {
                return [
                    'id' => $e->id,
                    'nom_complet' => $e->user->prenom . ' ' . $e->user->nom
                ];
            })
        );
    }

    public function destroy($id)
    {
        ModuleGroupeEnseignant::findOrFail($id)->delete();

        return back()->with('success', 'Relation supprimée');
    }
}
