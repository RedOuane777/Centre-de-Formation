<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudiantValidated
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'etudiant') {

            $etudiant = $user->etudiant;

            if (!$etudiant) {
                Auth::logout();
                return redirect()->route('pending');
            }

            if ($etudiant->status === 'pending') {
                Auth::logout();
                return redirect()->route('pending');
            }

            if ($etudiant->status === 'refused') {
                Auth::logout();
                return redirect()->route('refused');
            }

            if ($etudiant->status !== 'validated') {
                Auth::logout();
                return redirect()->route('pending');
            }
        }

        return $next($request);
    }
}