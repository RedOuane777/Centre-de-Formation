@extends('layouts.app')

@section('content')

<h2 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 1.8rem;">
    Ajouter un Examen
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

        <form action="{{ route('admin.examens.store') }}" method="POST">
            @csrf

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
                <label for="dateE" class="form-label">Date</label>
                <input type="date" name="dateE" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="typeE" class="form-label">Type</label>
                <input type="text" name="typeE" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="heure_debut" class="form-label">Heure début</label>
                <input type="time" name="heure_debut" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="heure_fin" class="form-label">Heure fin</label>
                <input type="time" name="heure_fin" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="salle" class="form-label">Salle</label>
                <input type="text" name="salle" class="form-control" required>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.examens.index') }}" class="btn btn-secondary shadow-sm">Annuler</a>
                <button type="submit" class="btn btn-success shadow-sm">
                    Enregistrer
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

    filiereSelect.addEventListener('change', function() {
        let filiereId = this.value;

        groupeSelect.innerHTML = '<option value="">-- Sélectionner un groupe --</option>';
        moduleSelect.innerHTML = '<option value="">-- Sélectionner un module --</option>';
        relationSelect.innerHTML = '<option value="">-- Sélectionner un enseignant --</option>';

        let groupes = {};

        relations.forEach(r => {
            if (r.groupe && r.groupe.filiere_id == filiereId) {
                groupes[r.groupe.id] = r.groupe;
            }
        });

        Object.values(groupes).forEach(g => {
            groupeSelect.appendChild(new Option(g.libelle, g.id));
        });
    });

    groupeSelect.addEventListener('change', function() {
        let groupeId = this.value;

        moduleSelect.innerHTML = '<option value="">-- Sélectionner un module --</option>';
        relationSelect.innerHTML = '<option value="">-- Sélectionner un enseignant --</option>';

        let modules = {};

        relations.forEach(r => {
            if (r.groupe && r.groupe.id == groupeId) {
                modules[r.module.id] = r.module;
            }
        });

        Object.values(modules).forEach(m => {
            moduleSelect.appendChild(new Option(m.titre, m.id));
        });
    });

    moduleSelect.addEventListener('change', function() {
        let moduleId = this.value;
        let groupeId = groupeSelect.value;

        relationSelect.innerHTML = '<option value="">-- Sélectionner un enseignant --</option>';

        relations.forEach(r => {
            if (
                r.module.id == moduleId &&
                r.groupe.id == groupeId &&
                r.enseignant &&
                r.enseignant.user
            ) {
                let text = `${r.enseignant.user.prenom} ${r.enseignant.user.nom}`;
                relationSelect.appendChild(new Option(text, r.id));
            }
        });
    });
</script>
@endsection