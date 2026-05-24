<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enseignant;
use App\Models\User;
use App\Models\Module;
use Illuminate\Support\Facades\Hash;

class EnseignantController extends Controller
{
    public function index(Request $request)
    {
        $query = Enseignant::with('user');

        if ($request->search) {
            $search = $request->search;
            $words = explode(' ', $search);

            $query->whereHas('user', function ($q) use ($words) {
                foreach ($words as $word) {
                    $q->where('nom', 'like', "%{$word}%")
                        ->orWhere('prenom', 'like', "%{$word}%");
                }
            });
        }

        $enseignants = $query->get();

        return view('admin.enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('admin.enseignants.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'gender' => 'required|in:male,female',
            'date_naissance' => 'required|date',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'enseignant',
            'gender' => $request->gender,
        ]);

        $enseignant = Enseignant::create([
            'user_id' => $user->id,
            'date_naissance' => $request->date_naissance,
        ]);

        return redirect()->route('admin.enseignants.index')->with('success', 'Enseignant créé avec succès.');
    }

    public function edit($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $modules = Module::all();

        return view('admin.enseignants.edit', compact('enseignant', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $user = $enseignant->user;

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'required|in:male,female',
            'date_naissance' => 'required|date',
        ]);

        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'gender' => $request->gender,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $enseignant->update([
            'date_naissance' => $request->date_naissance,
        ]);

        return redirect()->route('admin.enseignants.index')
            ->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $user = $enseignant->user;

        $enseignant->delete();
        $user->delete();

        return redirect()->route('admin.enseignants.index')->with('success', 'Enseignant supprimé avec succès.');
    }

    public function destroyAll()
    {
        $enseignants = Enseignant::all();

        foreach ($enseignants as $enseignant) {
            $enseignant->user()->delete();
            $enseignant->delete();
        }

        return redirect()->route('admin.enseignants.index')
            ->with('success', 'Tous les enseignants ont été supprimés avec succès');
    }
}
