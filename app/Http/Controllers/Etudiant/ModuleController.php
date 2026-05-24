<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Module;

class ModuleController extends Controller
{
    public function index()
    {
        $etudiant = auth()->user()->etudiant;

        if (!$etudiant) {
            abort(403, "Accès non autorisé.");
        }

        $modules = Module::whereHas('moduleGroupeEnseignants', function ($q) use ($etudiant) {
            $q->where('groupe_id', $etudiant->groupe_id);
        })
        ->with(['filiere'])
        ->get();

        return view('etudiant.modules.index', compact('modules', 'etudiant'));
    }
}