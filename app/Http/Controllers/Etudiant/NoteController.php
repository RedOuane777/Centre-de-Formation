<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Examen;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $etudiant = auth()->user()->etudiant;

        if (!$etudiant) {
            abort(403, "Vous n'êtes pas enregistré en tant qu'étudiant.");
        }

        $search = $request->search;

        $examens = Examen::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe',
            'notes'
        ])
            ->whereHas('moduleGroupeEnseignant', function ($q) use ($etudiant, $search) {

                $q->where('groupe_id', $etudiant->groupe_id)

                    ->when($search, function ($q2) use ($search) {
                        $q2->whereHas('module', function ($m) use ($search) {
                            $m->where('titre', 'like', "%{$search}%");
                        });
                    });
            })
            ->get();

        $modules = $examens->groupBy(function ($examen) {
            return $examen->moduleGroupeEnseignant->module->titre ?? 'Sans module';
        });

        return view('etudiant.notes.index', compact('modules', 'etudiant'));
    }
}
