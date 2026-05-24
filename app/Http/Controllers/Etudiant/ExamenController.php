<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Examen;

class ExamenController extends Controller
{
    public function index()
    {
        $etudiant = auth()->user()->etudiant;

        if (!$etudiant) {
            abort(403, "Vous n'êtes pas enregistré en tant qu'étudiant.");
        }

        $examens = Examen::with([
            'moduleGroupeEnseignant.module'
        ])
            ->whereHas('moduleGroupeEnseignant', function ($q) use ($etudiant) {
                $q->where('groupe_id', $etudiant->groupe_id);
            })
            ->orderBy('dateE')
            ->orderBy('typeE')
            ->get()
            ->groupBy(fn($e) => $e->moduleGroupeEnseignant->module->titre ?? 'Sans module');

        return view('etudiant.examens.index', compact('examens', 'etudiant'));
    }
}
