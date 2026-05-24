@extends('layouts.app')

@section('content')

<h2 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 1.8rem;">
    Modifier l'Enseignant
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

        <form action="{{ route('admin.enseignants.update', $enseignant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6">
                    <h5 class="mb-3 text-primary border-bottom pb-1">Informations personnelles</h5>

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control shadow-sm" value="{{ $enseignant->user->nom }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" id="prenom" class="form-control shadow-sm" value="{{ $enseignant->user->prenom }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Genre</label>
                        <select name="gender" id="gender" class="form-select shadow-sm" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="male" {{ $enseignant->user->gender == 'male' ? 'selected' : '' }}>Homme</option>
                            <option value="female" {{ $enseignant->user->gender == 'female' ? 'selected' : '' }}>Femme</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" name="date_naissance" id="date_naissance" class="form-control shadow-sm" value="{{ $enseignant->date_naissance }}" required>
                    </div>

                </div>

                <div class="col-md-6">
                    <h5 class="mb-3 text-primary border-bottom pb-1">Compte & Scolarité</h5>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control shadow-sm" value="{{ $enseignant->user->email }}" required>
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

                </div>

            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.enseignants.index') }}" class="btn btn-secondary shadow-sm">Annuler</a>
                <button type="submit" class="btn btn-success shadow-sm"><i class="bi bi-check-circle me-1"></i> Mettre à jour</button>
            </div>

        </form>

    </div>
</div>

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