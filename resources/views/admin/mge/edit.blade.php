@extends('layouts.app')

@section('content')

<h2 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 1.8rem;">
    Modifier une Relation MGE
</h2>

<div class="card shadow-sm border-0 rounded-lg" style="background-color: #f9fafb; max-width: 800px;">
    <div class="card-body p-4">

        <form method="POST" action="{{ route('admin.mge.update', $relation->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Filière</label>
                <select id="filiere_id" class="form-select shadow-sm" required>
                    <option value="">-- Sélectionner une filière --</option>
                    @foreach(\App\Models\Filiere::all() as $f)
                        <option value="{{ $f->id }}"
                            {{ $relation->module->filiere_id == $f->id ? 'selected' : '' }}>
                            {{ $f->libelle }}
                        </option>
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
                <a href="{{ route('admin.mge.index') }}" class="btn btn-secondary">
                    Annuler
                </a>

                <button type="submit" class="btn btn-success">
                    Mettre à jour
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

    const currentModule = @json($relation->module_id ?? null);
    const currentGroupe = @json($relation->groupe_id ?? null);
    const currentEnseignant = @json($relation->enseignant_id ?? null);

    function afficherEnseignants() {

        enseignantSelect.innerHTML = '<option value="">-- Sélectionner un enseignant --</option>';

        enseignants.forEach(e => {
            let nom = e.user.nom + ' ' + e.user.prenom;
            let opt = new Option(nom, e.id);

            if (currentEnseignant && e.id == currentEnseignant) {
                opt.selected = true;
            }

            enseignantSelect.appendChild(opt);
        });
    }

    afficherEnseignants();

    function loadFiliereData(filiereId) {

        groupeSelect.innerHTML = '<option value="">-- Sélectionner un groupe --</option>';
        moduleSelect.innerHTML = '<option value="">-- Sélectionner un module --</option>';

        groupes.forEach(g => {
            if (g.filiere_id == filiereId) {
                let opt = new Option(g.libelle, g.id);

                if (currentGroupe && g.id == currentGroupe) {
                    opt.selected = true;
                }

                groupeSelect.appendChild(opt);
            }
        });

        modules.forEach(m => {
            if (m.filiere_id == filiereId) {
                let opt = new Option(m.titre, m.id);

                if (currentModule && m.id == currentModule) {
                    opt.selected = true;
                }

                moduleSelect.appendChild(opt);
            }
        });
    }

    const currentFiliere = modules.find(m => m.id == currentModule)?.filiere_id;

    if (currentFiliere) {
        filiereSelect.value = currentFiliere;
        loadFiliereData(currentFiliere);
    }


    filiereSelect.addEventListener('change', function () {
        loadFiliereData(this.value);
    });

    moduleSelect.addEventListener('change', function () {
    });

});
</script>
@endsection