@extends('layouts.app')

@section('content')

<h2 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 1.8rem;">
    Modifier l'Examen
</h2>

@if ($errors->any())
<div class="alert alert-danger shadow-sm">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow-sm border-0 rounded-lg" style="background-color: #f9fafb; max-width: 800px">
    <div class="card-body">

        <form action="{{ route('admin.examens.update', $examen->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Filière</label>
                <select id="filiere" class="form-select">
                    <option value="">-- Sélectionner une filière --</option>
                    @foreach($filieres as $f)
                    <option value="{{ $f->id }}"
                        {{ $examen->moduleGroupeEnseignant->groupe->filiere_id == $f->id ? 'selected' : '' }}>
                        {{ $f->libelle }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Groupe</label>
                <select id="groupe" class="form-select">
                    <option value="">-- Sélectionner un groupe --</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Module</label>
                <select id="module" class="form-select">
                    <option value="">-- Sélectionner un module --</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Enseignant</label>
                <select name="module_groupe_enseignant_id" id="relation" class="form-select" required>
                    <option value="">-- Sélectionner un enseignant --</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="dateE" class="form-label">Date</label>
                <input type="date" name="dateE" class="form-control" value="{{ $examen->dateE }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" name="typeE" class="form-control" value="{{ $examen->typeE }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Heure début</label>
                <input type="time" name="heure_debut" class="form-control" value="{{ $examen->heure_debut }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Heure fin</label>
                <input type="time" name="heure_fin" class="form-control" value="{{ $examen->heure_fin }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Salle</label>
                <input type="text" name="salle" class="form-control" value="{{ $examen->salle }}" required>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.examens.index') }}" class="btn btn-secondary shadow-sm">Annuler</a>
                <button type="submit" class="btn btn-success shadow-sm">
                    Mettre à jour
                </button>
            </div>

        </form>

    </div>
</div>

<script>
const relations = @json($relations);

const filiereSelect = document.getElementById('filiere');
const groupeSelect = document.getElementById('groupe');
const moduleSelect = document.getElementById('module');
const relationSelect = document.getElementById('relation');

function populateGroupes(selectedId = null) {
    groupeSelect.innerHTML = '<option value="">-- Sélectionner un groupe --</option>';
    moduleSelect.innerHTML = '<option value="">-- Sélectionner un module --</option>';
    relationSelect.innerHTML = '<option value="">-- Sélectionner un enseignant --</option>';

    let groupes = {};

    relations.forEach(r => {
        if (r.groupe && r.groupe.filiere_id == filiereSelect.value) {
            groupes[r.groupe.id] = r.groupe;
        }
    });

    Object.values(groupes).forEach(g => {
        let option = new Option(g.libelle, g.id);
        groupeSelect.appendChild(option);
    });

    if (selectedId) {
        groupeSelect.value = selectedId;
    }
}

function populateModules(selectedId = null) {
    moduleSelect.innerHTML = '<option value="">-- Sélectionner un module --</option>';
    relationSelect.innerHTML = '<option value="">-- Sélectionner un enseignant --</option>';

    let modules = {};

    relations.forEach(r => {
        if (r.groupe && r.groupe.id == groupeSelect.value) {
            modules[r.module.id] = r.module;
        }
    });

    Object.values(modules).forEach(m => {
        moduleSelect.appendChild(new Option(m.titre, m.id));
    });

    if (selectedId) {
        moduleSelect.value = selectedId;
    }
}

function populateRelations(selectedId = null) {
    relationSelect.innerHTML = '<option value="">-- Sélectionner un enseignant --</option>';

    relations.forEach(r => {
        if (
            r.groupe.id == groupeSelect.value &&
            r.module.id == moduleSelect.value &&
            r.enseignant &&
            r.enseignant.user
        ) {
            let text = `${r.enseignant.user.prenom} ${r.enseignant.user.nom}`;
            relationSelect.appendChild(new Option(text, r.id));
        }
    });

    if (selectedId) {
        relationSelect.value = selectedId;
    }
}

filiereSelect.addEventListener('change', () => populateGroupes());
groupeSelect.addEventListener('change', () => populateModules());
moduleSelect.addEventListener('change', () => populateRelations());

const selectedRelId = {{ $examen->module_groupe_enseignant_id }};
const selectedRel = relations.find(r => r.id == selectedRelId);

if (selectedRel) {

    filiereSelect.value = selectedRel.groupe.filiere_id;

    populateGroupes(selectedRel.groupe.id);

    populateModules(selectedRel.module.id);

    populateRelations(selectedRel.id);
}
</script>

@endsection