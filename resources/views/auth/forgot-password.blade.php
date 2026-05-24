@extends('layouts.public')
@section('content')
<style>
    :root {
        --primary-color: #1D4ED8;
        --secondary-color: #1f6be6;
    }

    .page-wrapper {
        min-height: calc(100vh - 64px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: var(--bg-light);
        padding: 40px 16px;
    }

    .alert-top {
        width: 100%;
        max-width: 500px;
        margin-bottom: 16px;
    }

    .card {
        width: 100%;
        max-width: 500px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        background-color: #f9fafb;
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

    .text-small {
        font-size: 0.9rem;
    }

    h2 {
        font-size: 1.8rem;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 8px;
    }
</style>

<div class="page-wrapper">

    @if(session('success'))
    <div class="alert alert-success shadow-sm d-flex align-items-center alert-top">
        <i class="bi bi-check-circle me-2"></i>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    <div class="card shadow border-0 rounded-lg">
        <div class="card-body p-4">

            <h2 class="mb-4 text-center text-primary" style="font-weight: 600;">
                Mot de passe oublié
            </h2>

            @if ($errors->any())
            <div class="alert alert-danger shadow-sm d-flex align-items-center">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <div>{{ $errors->first() }}</div>
            </div>
            @endif

            <form method="POST" action="{{ route('password.send.code') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control shadow-sm"
                           value="{{ old('email') }}"
                           required>
                </div>
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-envelope me-1"></i>
                        Envoyer le code
                    </button>
                </div>
                <div class="text-center text-small mt-3">
                    <a href="{{ route('login') }}">Retour à la connexion</a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection