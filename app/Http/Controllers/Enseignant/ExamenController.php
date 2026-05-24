<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Examen;

class ExamenController extends Controller
{
    public function index()
    {
        $enseignant = Auth::user()->enseignant;

        $relationsIds = $enseignant->moduleGroupeEnseignants()->pluck('id');

        $examens = Examen::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe'
        ])
            ->whereIn('module_groupe_enseignant_id', $relationsIds)
            ->get();

        return view('enseignant.examens.index', compact('examens'));
    }

    public function editNotes($id)
    {
        $enseignant = Auth::user()->enseignant;

        $examen = Examen::with(
            'moduleGroupeEnseignant.groupe.etudiants.user'
        )->findOrFail($id);

        if (!$enseignant->moduleGroupeEnseignants
            ->pluck('id')
            ->contains($examen->module_groupe_enseignant_id)) {
            abort(403);
        }

        $etudiants = $examen->moduleGroupeEnseignant->groupe->etudiants;

        return view('enseignant.notes.edit', compact('examen', 'etudiants'));
    }

    public function storeNotes(Request $request, $id)
    {
        $enseignant = Auth::user()->enseignant;

        $examen = Examen::findOrFail($id);

        if (!$enseignant->moduleGroupeEnseignants
            ->pluck('id')
            ->contains($examen->module_groupe_enseignant_id)) {
            abort(403);
        }

        $notesData = $request->input('notes', []);

        foreach ($notesData as $etudiantId => $note) {

            $existingNote = $examen->notes()
                ->where('etudiant_id', $etudiantId)
                ->first();

            if ($note !== null && $note !== '') {

                $examen->notes()->updateOrCreate(
                    ['etudiant_id' => $etudiantId],
                    ['noteE' => $note]
                );
            } elseif ($existingNote) {
                $existingNote->delete();
            }
        }

        return redirect()
            ->route('enseignant.examens.index')
            ->with('success', 'Notes enregistrées avec succès.');
    }

    public function showNotes($id)
    {
        $notes = \App\Models\Note::with('etudiant.user', 'examen')
            ->where('examen_id', $id)
            ->get();

        return view('enseignant.notes.index', compact('notes'));
    }

    public function notes(Request $request)
    {
        $enseignant = Auth::user()->enseignant;

        $search = $request->search;

        $relationsIds = $enseignant->moduleGroupeEnseignants()->pluck('id');

        $examens = Examen::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe.etudiants.notes'
        ])
            ->whereIn('module_groupe_enseignant_id', $relationsIds)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('moduleGroupeEnseignant.module', function ($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%");
                })
                    ->orWhereHas('moduleGroupeEnseignant.groupe', function ($q) use ($search) {
                        $q->where('libelle', 'like', "%{$search}%");
                    });
            })
            ->get();

        return view('enseignant.notes.index', compact('examens'));
    }
}
