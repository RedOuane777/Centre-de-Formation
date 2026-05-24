@extends('layouts.app')

@section('content')
<h2 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 1.8rem;">
    Modifier l'Étudiant
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

<div class="card shadow border-0 rounded-lg" style="background-color: #f9fafb;">
    <div class="card-body">

        <form action="{{ route('admin.etudiants.update', $etudiant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6">

                    <h5 class="mb-3 text-primary border-bottom pb-1">Informations personnelles</h5>

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control shadow-sm" value="{{ $etudiant->user->nom }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" id="prenom" class="form-control shadow-sm" value="{{ $etudiant->user->prenom }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Genre</label>
                        <select name="gender" id="gender" class="form-select shadow-sm" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="male" {{ $etudiant->user->gender == 'male' ? 'selected' : '' }}>Homme</option>
                            <option value="female" {{ $etudiant->user->gender == 'female' ? 'selected' : '' }}>Femme</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" name="date_naissance"  id="date_naissance"class="form-control shadow-sm" value="{{ $etudiant->date_naissance }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="ville" class="form-label">Ville</label>
                        <input type="text" name="ville" id="ville" class="form-control shadow-sm" value="{{ $etudiant->ville }}" required>
                    </div>

                </div>

                <div class="col-md-6">

                    <h5 class="mb-3 text-primary border-bottom pb-1">Compte & Scolarité</h5>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control shadow-sm" value="{{ $etudiant->user->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
                        <div class="input-group shadow-sm">
                            <input type="password" name="password" id="password" class="form-control">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="code_etud" class="form-label">Code étudiant</label>
                        <input type="text" name="code_etud" id="code_etud" class="form-control shadow-sm" value="{{ $etudiant->code_etud }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="filiere_id" class="form-label">Filière</label>
                        <select name="filiere_id" id="filiere_id" class="form-select shadow-sm" required>
                            <option value="">-- Sélectionner une filière --</option>
                            @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}" {{ $etudiant->filiere_id == $filiere->id ? 'selected' : '' }}>
                                {{ $filiere->libelle }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="groupe_id" class="form-label">Groupe</label>
                        <select name="groupe_id" id="groupe_id" class="form-select shadow-sm" required>
                            <option value="">-- Sélectionner un groupe --</option>
                            @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}" data-filiere="{{ $groupe->filiere_id }}"
                                {{ $etudiant->groupe_id == $groupe->id ? 'selected' : '' }}>
                                {{ $groupe->libelle }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary shadow-sm">
                    Annuler
                </a>
                <button type="submit" class="btn btn-success shadow-sm">
                    <i class="bi bi-check-circle me-1"></i> Mettre à jour
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    document.getElementById('filiere_id').addEventListener('change', function() {
        let filiereId = this.value;
        let groupes = document.getElementById('groupe_id').options;

        for (let i = 0; i < groupes.length; i++) {
            let option = groupes[i];
            if (option.value === "") continue;
            option.style.display = option.dataset.filiere == filiereId ? "block" : "none";
        }

        document.getElementById('groupe_id').value = "";
    });

    window.addEventListener('load', function() {
        let filiereSelect = document.getElementById('filiere_id');
        let filiereId = filiereSelect.value;
        let groupes = document.getElementById('groupe_id').options;

        for (let i = 0; i < groupes.length; i++) {
            let option = groupes[i];
            if (option.value === "") continue;
            option.style.display = option.dataset.filiere == filiereId ? "block" : "none";
        }
    });
</script>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        let passwordInput = document.getElementById('password');
        let icon = this.querySelector('i');

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = "password";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>

@endsection