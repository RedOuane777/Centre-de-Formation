@extends('layouts.public')

@section('content')

<style>
    :root {
        --primary-color: #1D4ED8;
        --secondary-color: #3B82F6;
        --bg-light: #F3F4F6;
        --text-dark: #111827;
        --text-muted: #6B7280;
    }

    .reset-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-light);
        padding: 20px;
    }

    .card {
        width: 100%;
        max-width: 450px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        background-color: #f9fafb;
    }

    h2 {
        font-size: 1.6rem;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 10px;
    }

    .btn-success {
        width: 100%;
    }

    label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .text-small {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .togglePassword {
        cursor: pointer;
    }
</style>

<div class="reset-wrapper">

    <div class="card shadow border-0">

        <div class="card-body p-4">

            <h2 class="text-center text-success mb-3" style="font-weight: 600;">
                Nouveau mot de passe
            </h2>

            <p class="text-center text-small mb-3">
                Choisissez un mot de passe sécurisé
            </p>

            @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- ✅ تعديل مهم: إضافة email + token --}}
            <form method="POST" action="{{ route('password.reset') }}">
                @csrf

                <input type="hidden" name="email" value="{{ request('email') }}">
                <input type="hidden" name="token" value="{{ request('token') }}">

                {{-- PASSWORD --}}
                <div class="mb-3">
                    <label for="password">Mot de passe</label>

                    <div class="input-group shadow-sm">
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               required>

                        <button type="button"
                                class="btn btn-outline-secondary togglePassword"
                                data-target="password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="mb-3">
                    <label for="password_confirmation">Confirmer mot de passe</label>

                    <div class="input-group shadow-sm">
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               required>

                        <button type="button"
                                class="btn btn-outline-secondary togglePassword"
                                data-target="password_confirmation">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-success shadow-sm">
                    Modifier le mot de passe
                </button>

            </form>

        </div>

    </div>

</div>

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