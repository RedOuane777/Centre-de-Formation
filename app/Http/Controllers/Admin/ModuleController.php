<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Filiere;
use App\Models\Enseignant;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = Module::with('filiere');

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                    ->orWhereHas('filiere', function ($q2) use ($search) {
                        $q2->where('libelle', 'like', "%{$search}%");
                    });
            });
        }

        $modules = $query->get();

        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $filieres = Filiere::all();
        $enseignants = Enseignant::with('user')->get();
        return view('admin.modules.create', compact('filieres', 'enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'heures' => 'required|integer',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $module = Module::create($request->only(['titre', 'description', 'heures', 'filiere_id']));

        return redirect()->route('admin.modules.index')->with('success', 'Module créé avec succès');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $filieres = Filiere::all();
        return view('admin.modules.edit', compact('module', 'filieres'));
    }

    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $module->update($request->only([
            'titre',
            'description',
            'heures',
            'filiere_id'
        ]));

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module mis à jour avec succès');
    }

    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return redirect()->route('admin.modules.index')->with('success', 'Module supprimé avec succès.');
    }

    public function destroyAll()
    {
        $modules = Module::all();

        foreach ($modules as $module) {
            $module->delete();
        }

        return redirect()->route('admin.modules.index')
            ->with('success', 'Tous les modules ont été supprimés avec succès');
    }
}
