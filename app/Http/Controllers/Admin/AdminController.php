<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Module;
use App\Models\Groupe;
use App\Models\Filiere;
use App\Models\Examen;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalEtudiants = Etudiant::where('status', 'validated')->count();
        $totalEnseignants = Enseignant::count();
        $totalModules = Module::count();
        $totalExamens = Examen::count();
        $totalGroupes = Groupe::count();
        $totalFilieres = Filiere::count();

        return view('admin.dashboard', compact(
            'totalEtudiants',
            'totalEnseignants',
            'totalModules',
            'totalExamens',
            'totalGroupes',
            'totalFilieres'
        ));
    }
}