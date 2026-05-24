<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\EtudiantController as AdminEtudiantController;
use App\Http\Controllers\Admin\EnseignantController as AdminEnseignantController;
use App\Http\Controllers\Admin\ModuleController as AdminModuleController;
use App\Http\Controllers\Admin\GroupeController as AdminGroupeController;
use App\Http\Controllers\Admin\FiliereController as AdminFiliereController;
use App\Http\Controllers\Admin\ExamenController as AdminExamenController;
use App\Http\Controllers\Admin\NoteController as AdminNoteController;
use App\Http\Controllers\Admin\SeanceController as AdminSeanceController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\ModuleGroupeEnseignantController as AdminModuleGroupeEnseignantController;


// Enseignant Controllers
use App\Http\Controllers\Enseignant\EnseignantController as EnseignantEnseignantController;
use App\Http\Controllers\Enseignant\ModuleController as EnseignantModuleController;
use App\Http\Controllers\Enseignant\ExamenController as EnseignantExamenController;


// Etudiant Controllers
use App\Http\Controllers\Etudiant\EtudiantController as EtudiantEtudiantController;
use App\Http\Controllers\Etudiant\ExamenController as EtudiantExamenController;
use App\Http\Controllers\Etudiant\NoteController as EtudiantNoteController;
use App\Http\Controllers\Etudiant\ModuleController as EtudiantModuleController;



Route::get('/', function () {
    return view('welcome');
})->name('welcome');;

// Auth
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


Route::prefix('admin')->name('admin.')->middleware('auth', 'role:admin')->group(function () {

    // Dashboard
    Route::get('dashboard', [AdminAdminController::class, 'dashboard'])->name('dashboard');

    // En attente
    Route::get('etudiants/pending', [AdminEtudiantController::class, 'pending'])->name('etudiants.pending');
    Route::post('/etudiants/{id}/valider', [AdminEtudiantController::class, 'valider'])->name('etudiants.valider');
    Route::post('/etudiants/{id}/refuser', [AdminEtudiantController::class, 'refuser'])->name('etudiants.refuser');
    Route::post('etudiants/pending/refuser-all', [AdminEtudiantController::class, 'refuserAllPending'])->name('etudiants.refuserAllPending');

    // Refuser
    Route::get('etudiants/refused', [AdminEtudiantController::class, 'refused'])->name('etudiants.refused');
    Route::delete('etudiants/refused-all', [AdminEtudiantController::class, 'destroyRefusedAll'])->name('etudiants.destroyRefusedAll');

    // Étudiants
    Route::get('etudiants', [AdminEtudiantController::class, 'index'])->name('etudiants.index');
    Route::get('etudiants/{id}/edit', [AdminEtudiantController::class, 'edit'])->name('etudiants.edit');
    Route::put('etudiants/{id}', [AdminEtudiantController::class, 'update'])->name('etudiants.update');
    Route::delete('etudiants/destroy-all', [AdminEtudiantController::class, 'destroyAll'])->name('etudiants.destroyAll');
    Route::delete('etudiants/{id}', [AdminEtudiantController::class, 'destroy'])->name('etudiants.destroy');

    // Enseignants
    Route::get('enseignants', [AdminEnseignantController::class, 'index'])->name('enseignants.index');
    Route::get('enseignants/create', [AdminEnseignantController::class, 'create'])->name('enseignants.create');
    Route::post('enseignants', [AdminEnseignantController::class, 'store'])->name('enseignants.store');
    Route::get('enseignants/{id}/edit', [AdminEnseignantController::class, 'edit'])->name('enseignants.edit');
    Route::put('enseignants/{id}', [AdminEnseignantController::class, 'update'])->name('enseignants.update');
    Route::delete('enseignants/destroy-all', [AdminEnseignantController::class, 'destroyAll'])->name('enseignants.destroyAll');
    Route::delete('enseignants/{id}', [AdminEnseignantController::class, 'destroy'])->name('enseignants.destroy');

    // Modules
    Route::get('modules', [AdminModuleController::class, 'index'])->name('modules.index');
    Route::get('modules/create', [AdminModuleController::class, 'create'])->name('modules.create');
    Route::post('modules', [AdminModuleController::class, 'store'])->name('modules.store');
    Route::get('modules/{id}/edit', [AdminModuleController::class, 'edit'])->name('modules.edit');
    Route::put('modules/{id}', [AdminModuleController::class, 'update'])->name('modules.update');
    Route::delete('modules/destroy-all', [AdminModuleController::class, 'destroyAll'])->name('modules.destroyAll');
    Route::delete('modules/{id}', [AdminModuleController::class, 'destroy'])->name('modules.destroy');

    // Groupes
    Route::get('groupes', [AdminGroupeController::class, 'index'])->name('groupes.index');
    Route::get('groupes/create', [AdminGroupeController::class, 'create'])->name('groupes.create');
    Route::post('groupes', [AdminGroupeController::class, 'store'])->name('groupes.store');
    Route::get('groupes/{id}/edit', [AdminGroupeController::class, 'edit'])->name('groupes.edit');
    Route::put('groupes/{id}', [AdminGroupeController::class, 'update'])->name('groupes.update');
    Route::delete('groupes/destroy-all', [AdminGroupeController::class, 'destroyAll'])->name('groupes.destroyAll');
    Route::delete('groupes/{id}', [AdminGroupeController::class, 'destroy'])->name('groupes.destroy');

    // Filières
    Route::get('filieres', [AdminFiliereController::class, 'index'])->name('filieres.index');
    Route::get('filieres/create', [AdminFiliereController::class, 'create'])->name('filieres.create');
    Route::post('filieres', [AdminFiliereController::class, 'store'])->name('filieres.store');
    Route::get('filieres/{id}/edit', [AdminFiliereController::class, 'edit'])->name('filieres.edit');
    Route::put('filieres/{id}', [AdminFiliereController::class, 'update'])->name('filieres.update');
    Route::delete('filieres/destroy-all', [AdminFiliereController::class, 'destroyAll'])->name('filieres.destroyAll');
    Route::delete('filieres/{id}', [AdminFiliereController::class, 'destroy'])->name('filieres.destroy');

    // Examens
    Route::get('examens', [AdminExamenController::class, 'index'])->name('examens.index');
    Route::get('examens/create', [AdminExamenController::class, 'create'])->name('examens.create');
    Route::post('examens', [AdminExamenController::class, 'store'])->name('examens.store');
    Route::get('examens/{id}/edit', [AdminExamenController::class, 'edit'])->name('examens.edit');
    Route::put('examens/{id}', [AdminExamenController::class, 'update'])->name('examens.update');
    Route::delete('examens/destroy-all', [AdminExamenController::class, 'destroyAll'])->name('examens.destroyAll');
    Route::delete('examens/{id}', [AdminExamenController::class, 'destroy'])->name('examens.destroy');
    Route::get('notes', [AdminExamenController::class, 'notes'])->name('admin.notes.index');

    // Notes
    Route::get('examens/{id}/notes', [AdminNoteController::class, 'create'])->name('notes.create');
    Route::post('examens/{id}/notes', [AdminNoteController::class, 'store'])->name('notes.store');
    Route::get('notes/all', [AdminNoteController::class, 'index'])->name('notes.index');


    // Séances
    Route::get('seances', [AdminSeanceController::class, 'index'])->name('seances.index');
    Route::get('seances/create', [AdminSeanceController::class, 'create'])->name('seances.create');
    Route::post('seances', [AdminSeanceController::class, 'store'])->name('seances.store');
    Route::get('seances/{id}/edit', [AdminSeanceController::class, 'edit'])->name('seances.edit');
    Route::put('seances/{id}', [AdminSeanceController::class, 'update'])->name('seances.update');
    Route::delete('seances/destroy-all', [AdminSeanceController::class, 'destroyAll'])->name('seances.destroyAll');
    Route::delete('seances/{id}', [AdminSeanceController::class, 'destroy'])->name('seances.destroy');

    //Emploi
    Route::get('emploi', [AdminSeanceController::class, 'emploi'])->name('emploi.index');
    Route::get('emploi/search', [AdminSeanceController::class, 'emploiSearch'])->name('emploi.search');

    // Documents
    Route::get('documents', [AdminDocumentController::class, 'index'])->name('documents.index');
    Route::get('documents/attestation/{id}', [AdminDocumentController::class, 'attestation'])->name('documents.attestation');
    Route::get('documents/releve/{id}', [AdminDocumentController::class, 'releve'])->name('documents.releve');

    //MGE
    Route::get('/mge', [AdminModuleGroupeEnseignantController::class, 'index'])->name('mge.index');
    Route::get('/mge/create', [AdminModuleGroupeEnseignantController::class, 'create'])->name('mge.create');
    Route::post('/mge/store', [AdminModuleGroupeEnseignantController::class, 'store'])->name('mge.store');
    Route::delete('/mge/{id}', [AdminModuleGroupeEnseignantController::class, 'destroy'])->name('mge.destroy');
    Route::get('/modules/{id}/enseignants', [AdminModuleGroupeEnseignantController::class, 'enseignants']);
    Route::get('/mge/{id}/edit', [AdminModuleGroupeEnseignantController::class, 'edit'])->name('mge.edit');
    Route::put('/mge/{id}', [AdminModuleGroupeEnseignantController::class, 'update'])->name('mge.update');

});






//------------------------------------------------------------------------------------------------

Route::prefix('enseignant')->name('enseignant.')->middleware('auth', 'role:enseignant')->group(function () {

    // Dashboard
    Route::get('dashboard', [EnseignantEnseignantController::class, 'index'])->name('dashboard');

    // Modules
    Route::get('modules', [EnseignantModuleController::class, 'index'])->name('modules.index');
    Route::get('modules/{id}/show', [EnseignantModuleController::class, 'show'])->name('modules.show');

    //Emploi
    Route::get('emploi', [EnseignantEnseignantController::class, 'emploiDuTemps'])->name('emploi');

    // Examens
    Route::get('/examens', [EnseignantExamenController::class, 'index'])->name('examens.index');

    Route::get('/examens/{id}/notes/edit', [EnseignantExamenController::class, 'editNotes'])->name('notes.edit');
    Route::post('/examens/{id}/notes', [EnseignantExamenController::class, 'storeNotes'])->name('notes.store');

    Route::get('/examens/{id}/notes', [EnseignantExamenController::class, 'showNotes'])->name('notes.show');

    Route::get('/notes', [EnseignantExamenController::class, 'notes'])->name('notes.index');

    //Notes
    Route::get('examens/{id}/notes', [EnseignantExamenController::class, 'editNotes'])->name('notes.edit');

    Route::post('examens/{id}/notes', [EnseignantExamenController::class, 'storeNotes'])->name('notes.store');

    Route::get('examens/{id}/notes/show', [EnseignantExamenController::class, 'showNotes'])->name('notes.show');

    //Groupes
    Route::get('groupes', [EnseignantEnseignantController::class, 'groupes'])->name('groupes.index');
    Route::get('groupes/{id}/etudiants', [EnseignantEnseignantController::class, 'getEtudiants']);
});




//----------------------------------------------------------------------------------------

Route::prefix('etudiant')->name('etudiant.')->middleware(['auth', 'etudiant.validated'])->group(function () {

    // Dashboard
    Route::get('dashboard', [EtudiantEtudiantController::class, 'dashboard'])->name('dashboard');

    // Emploi du temps
    Route::get('emploi', [EtudiantEtudiantController::class, 'emploiDuTemps'])->name('emploi');

    // Modules
    Route::get('/modules', [EtudiantModuleController::class, 'index'])->name('modules.index');

    // Groupes
    Route::get('groupes/{id}/etudiants', [EtudiantEtudiantController::class, 'getEtudiants']);

    // Examens
    Route::get('examens', [EtudiantExamenController::class, 'index'])->name('examens.index');

    // Notes
    Route::get('notes', [EtudiantNoteController::class, 'index'])->name('notes.index');
});


//------------------------------------------------------------------------------



Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/pending', function () {
    return view('auth.pending');
})->name('pending');

Route::get('/refused', function () {
    return view('auth.refused');
})->name('refused');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');



Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


Route::post('/change-password', [ProfileController::class, 'changePassword'])
    ->name('change.password')
    ->middleware('auth');


Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.forgot');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendCode'])->name('password.send.code');
Route::get('/verify-code', [ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.verify');

Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');