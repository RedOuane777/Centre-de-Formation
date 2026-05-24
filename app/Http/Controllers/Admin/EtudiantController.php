<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\Filiere;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    public function index(Request $request)
    {
        $query = Etudiant::with('user', 'filiere', 'groupe')
            ->where('status', 'validated');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $words = explode(' ', $search);

            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $q->whereHas('user', function ($q2) use ($word) {
                        $q2->where('nom', 'like', "%{$word}%")
                            ->orWhere('prenom', 'like', "%{$word}%")
                            ->orWhere('email', 'like', "%{$word}%");
                    })->orWhere('code_etud', 'like', "%{$word}%");
                }
            });
        }

        $etudiants = $query->get();

        return view('admin.etudiants.index', compact('etudiants'));
    }

    public function edit($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $groupes = Groupe::all();
        $filieres = Filiere::all();
        return view('admin.etudiants.edit', compact('etudiant', 'groupes', 'filieres'));
    }

    public function update(Request $request, $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $user = $etudiant->user;

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'code_etud' => 'required|string|unique:etudiants,code_etud,' . $etudiant->id,
            'groupe_id' => 'nullable|exists:groupes,id',
            'filiere_id' => 'required|exists:filieres,id',
            'date_naissance' => 'required|date',
            'ville' => 'required|string|max:255',
        ]);

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->gender = $request->gender;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $etudiant->update([
            'code_etud' => $request->code_etud,
            'groupe_id' => $request->groupe_id,
            'filiere_id' => $request->filiere_id,
            'date_naissance' => $request->date_naissance,
            'ville' => $request->ville,
        ]);

        return redirect()->route('admin.etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->user()->delete();
        $etudiant->delete();

        return redirect()->route('admin.etudiants.index')->with('success', 'Étudiant supprimé avec succès.');
    }
    public function destroyAll()
    {
        $etudiants = Etudiant::all();

        foreach ($etudiants as $etudiant) {
            $etudiant->documents()->delete();

            $etudiant->user()->delete();

            $etudiant->delete();
        }

        return redirect()->route('admin.etudiants.index')
            ->with('success', 'Tous les étudiants ont été supprimés avec succès');
    }

    public function pending(Request $request)
    {
        $query = Etudiant::with(['user', 'filiere'])
            ->where('status', 'pending');

        if ($request->has('search') && $request->search != '') {

            $search = $request->search;
            $words = explode(' ', $search);

            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $q->whereHas('user', function ($q2) use ($word) {
                        $q2->where('nom', 'like', "%{$word}%")
                            ->orWhere('prenom', 'like', "%{$word}%")
                            ->orWhere('email', 'like', "%{$word}%");
                    })
                        ->orWhere('code_etud', 'like', "%{$word}%");
                }
            });
        }

        $etudiants = $query->get();

        return view('admin.etudiants.pending', compact('etudiants'));
    }

    public function refuserAllPending()
    {
        Etudiant::where('status', 'pending')->update([
            'status' => 'refused'
        ]);

        return redirect()->back()->with('success', 'Tous les étudiants ont été refusés.');
    }

    public function valider(Request $request, $id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $groupe = Groupe::where('filiere_id', $etudiant->filiere_id)
            ->withCount('etudiants')
            ->orderBy('etudiants_count', 'asc')
            ->first();

        $etudiant->update([
            'status' => 'validated',
            'groupe_id' => $groupe?->id,
        ]);

        return redirect()->back()->with('success', 'Étudiant validé avec succès.');
    }

    public function refused(Request $request)
    {
        $query = Etudiant::with(['user', 'filiere'])
            ->where('status', 'refused');

        if ($request->has('search') && $request->search != '') {

            $search = $request->search;
            $words = explode(' ', $search);

            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $q->whereHas('user', function ($q2) use ($word) {
                        $q2->where('nom', 'like', "%{$word}%")
                            ->orWhere('prenom', 'like', "%{$word}%")
                            ->orWhere('email', 'like', "%{$word}%");
                    });
                }
            });
        }

        $etudiants = $query->get();

        return view('admin.etudiants.refused', compact('etudiants'));
    }

    public function refuser($id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $etudiant->update([
            'status' => 'refused'
        ]);

        return redirect()->back()->with('success', 'Étudiant refusé avec succès.');
    }

    public function destroyRefusedAll()
    {
        $etudiants = Etudiant::where('status', 'refused')->get();

        foreach ($etudiants as $etudiant) {
            $etudiant->user()->delete();
            $etudiant->delete();
        }

        return redirect()->back()->with('success', 'Tous les étudiants refusés ont été supprimés.');
    }
}
