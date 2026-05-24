<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role == 'enseignant') {
                return redirect()->route('enseignant.dashboard');
            }

            if ($user->role == 'etudiant') {
                return redirect()->route('etudiant.dashboard');
            }
        }

        return back()
            ->withErrors([
                'email' => 'Email ou mot de passe incorrect.',
            ])
            ->withInput();
    }
}