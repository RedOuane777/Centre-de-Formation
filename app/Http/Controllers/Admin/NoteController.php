<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Examen;
use App\Models\Enseignant;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $examens = Examen::with([
            'moduleGroupeEnseignant.module',
            'moduleGroupeEnseignant.groupe.etudiants.notes'
        ])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('moduleGroupeEnseignant.module', function ($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%");
                })
                    ->orWhereHas('moduleGroupeEnseignant.groupe', function ($q) use ($search) {
                        $q->where('libelle', 'like', "%{$search}%");
                    });
            })
            ->get();

        return view('admin.notes.index', compact('examens'));
    }

    public function create($id)
    {
        $enseignant = Enseignant::where('user_id', auth()->id())->first();

        if ($enseignant) {
            $examen = Examen::with('moduleGroupeEnseignant.groupe.etudiants.user')
                ->whereIn(
                    'module_groupe_enseignant_id',
                    $enseignant->moduleGroupeEnseignants->pluck('id')
                )
                ->findOrFail($id);
        } else {
            $examen = Examen::with('moduleGroupeEnseignant.groupe.etudiants.user')
                ->findOrFail($id);
        }

        $etudiants = $examen->moduleGroupeEnseignant->groupe->etudiants;

        return view('admin.notes.create', compact('examen', 'etudiants'));
    }

    public function store(Request $request, $id)
    {
        foreach ($request->notes as $etudiant_id => $note) {

            if ($note === null || $note === '') {
                continue;
            }

            Note::updateOrCreate(
                [
                    'etudiant_id' => $etudiant_id,
                    'examen_id' => $id
                ],
                [
                    'noteE' => $note
                ]
            );
        }

        return redirect()->route('admin.examens.index')
            ->with('success', 'Notes enregistrées avec succès');
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note supprimée avec succès');
    }
}
