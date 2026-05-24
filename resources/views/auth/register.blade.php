@extends('layouts.public')
@section('content')

<div class="container">
    <h2 class="mb-4 mt-4 text-center" style="color: var(--bs-dark); font-weight: 600; font-size: 1.8rem;">
        Inscription Étudiant
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

    <div class="card shadow border-0 rounded-lg" style="background-color: #f9fafb; max-width: 800px; margin: 40px auto;">
        <div class="card-body">

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6">

                        <h5 class="mb-3 text-primary border-bottom pb-1">Informations personnelles</h5>

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control shadow-sm" required
                                   value="{{ old('nom') }}">
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control shadow-sm" required
                                   value="{{ old('prenom') }}">
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Genre</label>
                            <select name="gender" id="gender" class="form-select shadow-sm" required>
                                <option value="">-- Sélectionner --</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Homme</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femme</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" name="date_naissance" id="date_naissance" class="form-control shadow-sm" required
                                   value="{{ old('date_naissance') }}">
                        </div>

                        <div class="mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" name="ville" id="ville" class="form-control shadow-sm" required
                                   value="{{ old('ville') }}">
                        </div>

                    </div>

                    <div class="col-md-6">

                        <h5 class="mb-3 text-primary border-bottom pb-1">Compte & Filière</h5>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control shadow-sm" required
                                   value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group shadow-sm">
                                <input type="password" name="password" id="password" class="form-control" required>
                                <button type="button" class="btn btn-outline-secondary togglePassword" data-target="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <div class="input-group shadow-sm">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <button type="button" class="btn btn-outline-secondary togglePassword" data-target="password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="filiere_id" class="form-label">Filière</label>
                            <select name="filiere_id" id="filiere_id" class="form-select shadow-sm" required>
                                <option value="">-- Sélectionner une filière --</option>
                                @foreach($filieres as $filiere)
                                    <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                        {{ $filiere->libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('welcome') }}" class="btn btn-secondary shadow-sm">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-success shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Envoyer la demande
                    </button>
                </div>

                <div class="mt-3 text-center">
                    <small>Vous avez déjà un compte? <a href="{{ route('login') }}">Connectez-vous</a></small>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelectorAll('.togglePassword').forEach(function(btn) {
        btn.addEventListener('click', function() {
            let targetId = this.dataset.target;
            let input = document.getElementById(targetId);
            let icon = this.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>

@endsection