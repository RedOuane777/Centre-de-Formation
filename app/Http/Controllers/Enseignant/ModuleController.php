<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;

class ModuleController extends Controller
{
    public function index()
    {
        $enseignant = Auth::user()->enseignant;

        $relations = $enseignant->moduleGroupeEnseignants()
            ->with('groupe')
            ->get();

        $modules = Module::whereIn(
            'id',
            $relations->pluck('module_id')
        )->get();

        return view('enseignant.modules.index', compact('modules', 'relations'));
    }
}