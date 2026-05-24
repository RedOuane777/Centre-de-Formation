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

    .otp-wrapper {
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

    .otp-boxes {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin: 25px 0;
    }

    .otp-boxes input {
        width: 55px;
        height: 55px;
        text-align: center;
        font-size: 22px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        width: 100%;
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .text-small {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    h2 {
        font-size: 1.6rem;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 10px;
    }

    .alert-top {
        margin-bottom: 15px;
    }
</style>

<div class="otp-wrapper">

    <div class="card shadow border-0">

        <div class="card-body p-4">

            <h2 class="text-center text-primary mb-3" style="font-weight: 600;">
                Vérification du code
            </h2>

            <p class="text-center text-small mb-3">
                Entrez le code envoyé à votre email
            </p>

            @if ($errors->any())
            <div class="alert alert-danger shadow-sm alert-top">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.verify') }}" id="otp-form">
                @csrf

                <input type="hidden" name="email" value="{{ request('email') }}">
                <input type="hidden" name="token" value="{{ request('token') }}">
                <input type="hidden" name="code" id="full-code">

                <div class="otp-boxes">
                    @for($i = 0; $i < 6; $i++)
                        <input type="text" maxlength="1" class="otp-box">
                        @endfor
                </div>

                <button class="btn btn-primary shadow-sm">
                    Vérifier
                </button>
            </form>

        </div>
    </div>

</div>

<script>
    const inputs = document.querySelectorAll('.otp-box');
    const hiddenInput = document.getElementById('full-code');

    function updateCode() {
        let code = '';
        inputs.forEach(i => code += i.value);
        hiddenInput.value = code;
    }

    inputs.forEach((input, index) => {

        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            updateCode();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();

            let paste = (e.clipboardData || window.clipboardData)
                .getData('text')
                .replace(/\D/g, '')
                .trim();

            if (paste.length === 6) {
                inputs.forEach((inp, i) => inp.value = paste[i] || '');
                updateCode();
                inputs[inputs.length - 1].focus();
            }
        });
    });
</script>

@endsection