@extends('layouts.app')

@section('content')

<h2 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 1.8rem;">
    Ajouter une Relation MGE
</h2>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="card shadow-sm border-0 rounded-lg" style="background-color: #f9fafb; max-width: 800px;">
    <div class="card-body p-4">

        <form method="POST" action="{{ route('admin.mge.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Filière</label>
                <select id="filiere_id" class="form-select shadow-sm" required>
                    <option value="">-- Sélectionner une filière --</option>
                    @foreach(\App\Models\Filiere::all() as $f)
                    <option value="{{ $f->id }}">{{ $f->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Module</label>
                <select name="module_id" id="module_id" class="form-select shadow-sm" required>
                    <option value="">-- Sélectionner un module --</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Groupe</label>
                <select name="groupe_id" id="groupe_id" class="form-select shadow-sm" required>
                    <option value="">-- Sélectionner un groupe --</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Enseignant</label>
                <select name="enseignant_id" id="enseignant_id" class="form-select shadow-sm" required>
                    <option value="">-- Sélectionner un enseignant --</option>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.mge.index') }}" class="btn btn-secondary shadow-sm">
                    Annuler
                </a>

                <button type="submit" class="btn btn-success shadow-sm">
                    <i class="bi bi-check-circle me-1"></i>
                    Enregistrer
                </button>
            </div>

        </form>

    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const filiereSelect = document.getElementById('filiere_id');
    const groupeSelect = document.getElementById('groupe_id');
    const moduleSelect = document.getElementById('module_id');
    const enseignantSelect = document.getElementById('enseignant_id');

    const groupes = @json(\App\Models\Groupe::all());
    const modules = @json(\App\Models\Module::all());

    const enseignants = @json(\App\Models\Enseignant::with('user')->get());

    function afficherEnseignants() {

        enseignantSelect.innerHTML = '<option value="">-- Sélectionner un enseignant --</option>';

        enseignants.forEach(e => {
            let nom = e.user.nom + ' ' + e.user.prenom;
            enseignantSelect.appendChild(new Option(nom, e.id));
        });
    }

    afficherEnseignants();

    filiereSelect.addEventListener('change', function () {

        let filiereId = this.value;

        groupeSelect.innerHTML = '<option value="">-- Sélectionner un groupe --</option>';
        moduleSelect.innerHTML = '<option value="">-- Sélectionner un module --</option>';

        groupes.forEach(g => {
            if (g.filiere_id == filiereId) {
                groupeSelect.appendChild(new Option(g.libelle, g.id));
            }
        });

        modules.forEach(m => {
            if (m.filiere_id == filiereId) {
                moduleSelect.appendChild(new Option(m.titre, m.id));
            }
        });

    });

    moduleSelect.addEventListener('change', function () {
        let moduleId = this.value;
        let groupeId = groupeSelect.value;

        if (!moduleId) return;
    });

});
</script>
@endsection