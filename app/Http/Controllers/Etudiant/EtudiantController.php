<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Seance;
use App\Models\Module;
use App\Models\Examen;
use App\Models\Groupe;

class EtudiantController extends Controller
{
    public function dashboard()
    {
        $etudiant = Auth::user()->etudiant;

        if (!$etudiant) {
            abort(403, "Vous n'êtes pas enregistré en tant qu'étudiant.");
        }

        $groupe = $etudiant->groupe;

        $modules_count = Module::whereHas('moduleGroupeEnseignants', function ($q) use ($groupe) {
            $q->where('groupe_id', $groupe->id);
        })->count();

        $examens_count = Examen::whereHas('moduleGroupeEnseignant', function ($q) use ($groupe) {
            $q->where('groupe_id', $groupe->id);
        })->count();

        return view('etudiant.dashboard', compact(
            'etudiant',
            'groupe',
            'modules_count',
            'examens_count'
        ));
    }

    public function emploiDuTemps()
    {
        $etudiant = auth()->user()->etudiant;

        if (!$etudiant) {
            abort(403, "Vous n'êtes pas enregistré en tant qu'étudiant.");
        }

        $seances = Seance::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe',
            'moduleGroupeEnseignant.enseignant.user'
        ])
            ->whereHas('moduleGroupeEnseignant', function ($q) use ($etudiant) {
                $q->where('groupe_id', $etudiant->groupe_id);
            })
            ->get();

        $examens = Examen::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe',
            'moduleGroupeEnseignant.enseignant.user'
        ])
            ->whereHas('moduleGroupeEnseignant', function ($q) use ($etudiant) {
                $q->where('groupe_id', $etudiant->groupe_id);
            })
            ->get();

        $groupes = Groupe::where('id', $etudiant->groupe_id)->get();

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        $events = collect()
            ->merge($seances->map(function ($s) {
                $s->type = 'seance';
                return $s;
            }))
            ->merge($examens->map(function ($e) {
                $e->type = 'examen';
                return $e;
            }));

        return view('etudiant.emploi.index', compact('events', 'groupes', 'jours', 'etudiant'));
    }

    public function getEtudiants($id)
    {
        $groupe = \App\Models\Groupe::with('etudiants.user')->findOrFail($id);
        return response()->json($groupe->etudiants);
    }
}
