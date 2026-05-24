<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Seance;
use App\Models\Groupe;
use App\Models\Examen;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignant = Auth::user()->enseignant;

        if (!$enseignant) {
            abort(403, "Vous n'êtes pas enregistré en tant qu'enseignant.");
        }

        $relations = $enseignant->moduleGroupeEnseignants();

        $modules_count = $relations->distinct('module_id')->count('module_id');

        $groupes_count = $relations->distinct('groupe_id')->count('groupe_id');

        $examens_count = Examen::whereIn(
            'module_groupe_enseignant_id',
            $enseignant->moduleGroupeEnseignants->pluck('id')
        )->count();

        return view('enseignant.dashboard', compact(
            'modules_count',
            'groupes_count',
            'examens_count'
        ));
    }

    public function emploiDuTemps()
    {
        $enseignant = Auth::user()->enseignant;

        if (!$enseignant) {
            abort(403, "Vous n'êtes pas enregistré en tant qu'enseignant.");
        }

        $seances = Seance::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe',
            'moduleGroupeEnseignant.enseignant.user'
        ])
            ->whereHas('moduleGroupeEnseignant', function ($q) use ($enseignant) {
                $q->where('enseignant_id', $enseignant->id);
            })
            ->get();

        $examens = Examen::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe',
            'moduleGroupeEnseignant.enseignant.user'
        ])
            ->whereHas('moduleGroupeEnseignant', function ($q) use ($enseignant) {
                $q->where('enseignant_id', $enseignant->id);
            })
            ->get();

        $groupes = Groupe::all();
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

        return view('enseignant.emploi.index', compact('events', 'groupes', 'jours'));
    }

    public function groupes()
    {
        $enseignant = Auth::user()->enseignant;

        $groupes = Groupe::whereIn(
            'id',
            $enseignant->moduleGroupeEnseignants->pluck('groupe_id')
        )->with('etudiants.user')->get();

        return view('enseignant.groupes.index', compact('groupes'));
    }

    public function getEtudiants($id)
    {
        $groupe = Groupe::with('etudiants.user')->findOrFail($id);

        return response()->json($groupe->etudiants);
    }
}
