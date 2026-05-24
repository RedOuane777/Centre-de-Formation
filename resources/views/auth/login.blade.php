@extends('layouts.public')
@section('content')
<style>
    :root {
        --primary-color: #1D4ED8;
        --secondary-color: #3B82F6;
        --success-color: #10B981;
        --bg-light: #F3F4F6;
        --text-dark: #111827;
        --text-muted: #6B7280;
    }

    .card {
        max-width: 500px;
        margin: 80px auto 80px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        background-color: #f9fafb;
    }

    .alert-top {
        max-width: 1000px;
        margin: 40px auto 0;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .form-label {
        font-weight: 500;
    }

    .togglePassword {
        cursor: pointer;
    }

    .text-small {
        font-size: 0.9rem;
    }

    h2 {
        font-size: 1.8rem;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 8px;
    }
</style>

@if(session('success'))
<div class="alert alert-success shadow-sm d-flex align-items-center alert-top">
    <i class="bi bi-check-circle me-2"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

<div class="card shadow border-0 rounded-lg">
    <div class="card-body p-4">

        <h2 class="mb-4 text-center text-primary" style="font-weight: 600;">Se connecter</h2>

        @if ($errors->any())
        <div class="alert alert-danger shadow-sm d-flex align-items-center">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <div>{{ $errors->first() }}</div>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control shadow-sm @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group shadow-sm">
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    <button type="button" class="btn btn-outline-secondary togglePassword" data-target="password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-end mt-1">
                <a href="{{ route('password.forgot') }}" class="text-small">
                    Mot de passe oublié ?
                </a>
            </div>
            <div class="mt-4 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                </button>
            </div>
            <div class="text-center text-small mt-3">
                Vous n'avez pas de compte ?
                <a href="{{ route('register.create') }}">Inscrivez-vous ici</a>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
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