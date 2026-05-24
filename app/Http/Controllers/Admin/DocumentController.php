<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Etudiant::with('user', 'filiere', 'groupe')
            ->where('status', 'validated');

        if ($request->search) {
            $search = $request->search;
            $words = explode(' ', $search);

            $query->where(function ($q) use ($words) {

                foreach ($words as $word) {

                    $q->whereHas('user', function ($q2) use ($word) {
                        $q2->where('nom', 'like', "%{$word}%")
                            ->orWhere('prenom', 'like', "%{$word}%");
                    })

                        ->orWhereHas('filiere', function ($q3) use ($word) {
                            $q3->where('libelle', 'like', "%{$word}%");
                        })

                        ->orWhereHas('groupe', function ($q4) use ($word) {
                            $q4->where('libelle', 'like', "%{$word}%");
                        });
                }
            });
        }

        $etudiants = $query->get();

        return view('admin.documents.index', compact('etudiants'));
    }

    public function attestation($id)
    {
        $etudiant = Etudiant::with('user', 'filiere', 'groupe')->findOrFail($id);
        $pdf = Pdf::loadView('pdf.attestation', compact('etudiant'))->setPaper('A4', 'landscape');
        return $pdf->download('attestation_' . $etudiant->user->nom . '.pdf');
    }

    public function releve($id)
    {
        $etudiant = Etudiant::with([
            'user',
            'filiere',
            'groupe',
            'notes.examen.moduleGroupeEnseignant.module'
        ])->findOrFail($id);

        $modulesData = [];
        $totalModulesMoyennes = 0;
        $modulesCount = 0;
        $maxNotesCount = 0;

        $groupedNotes = $etudiant->notes->groupBy(function ($note) {
            return $note->examen->moduleGroupeEnseignant->module->id ?? 0;
        });

        foreach ($groupedNotes as $moduleId => $notes) {
            if ($moduleId == 0) continue;

            $moduleTitle = $notes->first()->examen->moduleGroupeEnseignant->module->titre ?? '-';
            $sumNotes = 0;
            $countNotes = 0;
            $filteredNotes = [];

            foreach ($notes as $note) {
                if ($note->noteE !== null) {
                    $sumNotes += $note->noteE;
                    $countNotes++;
                    $filteredNotes[] = $note->noteE;
                }
            }

            if (count($filteredNotes) > $maxNotesCount) {
                $maxNotesCount = count($filteredNotes);
            }

            $moduleMoyenne = $countNotes > 0 ? round($sumNotes / $countNotes, 2) : null;

            if ($moduleMoyenne !== null) {
                $totalModulesMoyennes += $moduleMoyenne;
                $modulesCount++;
            }

            $modulesData[] = [
                'titre' => $moduleTitle,
                'notes' => $filteredNotes,
                'moyenne' => $moduleMoyenne
            ];
        }

        if ($maxNotesCount == 0) {
            $maxNotesCount = 1;
        }

        $moyenneGenerale = $modulesCount > 0 ? round($totalModulesMoyennes / $modulesCount, 2) : 0;

        return PDF::loadView('pdf.releve', compact('etudiant', 'modulesData', 'moyenneGenerale', 'maxNotesCount'))
            ->setPaper('A4', 'portrait')
            ->stream('releve_' . $etudiant->user->nom . '.pdf');
    }
}
