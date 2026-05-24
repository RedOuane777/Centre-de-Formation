@extends('layouts.app')

@section('content')

<h2 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 1.8rem;">
    Modifier la Séance
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

        <form action="{{ route('admin.seances.update', $seance->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Filière</label>
                <select id="filiere" class="form-select">
                    <option value="">-- Sélectionner une filière --</option>
                    @foreach($filieres as $f)
                    <option value="{{ $f->id }}">{{ $f->libelle }}</option>
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
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ $seance->date }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Heure début</label>
                <input type="time" name="heure_debut" class="form-control" value="{{ $seance->heure_debut }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Heure fin</label>
                <input type="time" name="heure_fin" class="form-control" value="{{ $seance->heure_fin }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Salle</label>
                <input type="text" name="salle" class="form-control" value="{{ $seance->salle }}" required>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.seances.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-success">Mettre à jour</button>
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

function populateGroupes() {
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
        groupeSelect.appendChild(new Option(g.libelle, g.id));
    });
}

function populateModules() {
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
}

function populateRelations() {
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
}

filiereSelect.addEventListener('change', populateGroupes);
groupeSelect.addEventListener('change', populateModules);
moduleSelect.addEventListener('change', populateRelations);

const selectedRel = relations.find(r => r.id == {{ $seance->module_groupe_enseignant_id }});
if (selectedRel) {
    filiereSelect.value = selectedRel.groupe.filiere_id;
    populateGroupes();
    groupeSelect.value = selectedRel.groupe.id;
    populateModules();
    moduleSelect.value = selectedRel.module.id;
    populateRelations();
    relationSelect.value = selectedRel.id;
}
</script>

@endsection