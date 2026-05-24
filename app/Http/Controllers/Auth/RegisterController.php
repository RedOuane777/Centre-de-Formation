<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Filiere;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        $filieres = Filiere::all();
        return view('auth.register', compact('filieres'));
    }

    private function cleanText($value)
    {
        return ucwords(strtolower(trim($value)));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[A-Za-zÀ-ÿ\s\-]+$/'
            ],

            'prenom' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[A-Za-zÀ-ÿ\s\-]+$/'
            ],

            'email' => 'required|email|unique:users,email',

            'password' => ['required', 'confirmed', Password::defaults()],

            'gender' => 'required|in:male,female',

            'date_naissance' => [
                'required',
                'date',
                'before:-10 years',
                'after:1900-01-01'
            ],

            'ville' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[A-Za-zÀ-ÿ\s\-]+$/'
            ],

            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $nom = $this->cleanText($validated['nom']);
        $prenom = $this->cleanText($validated['prenom']);
        $ville = $this->cleanText($validated['ville']);

        $user = User::create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'etudiant',
            'gender' => $validated['gender'],
        ]);

        Etudiant::create([
            'user_id' => $user->id,
            'filiere_id' => $validated['filiere_id'],
            'groupe_id' => null,
            'date_naissance' => $validated['date_naissance'],
            'ville' => $ville,
            'status' => 'pending',
            'code_etud' => 'ET' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
        ]);

        return redirect()
            ->route('login')
            ->with('success', "Votre demande a été envoyée avec succès. En attente de validation par l'admin.");
    }
}