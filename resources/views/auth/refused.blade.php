@extends('layouts.public')
@section('content')
<style>
    .refused-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        background: white;
    }
    .box {
        background: white;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.10), 0 1px 4px rgba(0,0,0,0.06);
        max-width: 480px;
        width: 100%;
        overflow: hidden;
        border: 1px solid #E5E7EB;
    }
    .box-header {
        background: linear-gradient(135deg, #7f1d1d, #EF4444);
        padding: 30px;
        text-align: center;
    }
    .box-header i {
        font-size: 2.5rem;
        color: #FCA5A5;
        margin-bottom: 10px;
        display: block;
    }
    .box-header h1 {
        color: white;
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0;
    }
    .box-body {
        padding: 35px 40px;
        text-align: center;
        background: white;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FEF2F2;
        color: #991B1B;
        border: 1px solid #FECACA;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .box-body p {
        color: #6B7280;
        line-height: 1.7;
        font-size: 0.95rem;
        margin-bottom: 25px;
    }
    .box-footer {
        border-top: 1px solid #F3F4F6;
        padding: 20px 40px;
        display: flex;
        justify-content: center;
        gap: 12px;
        background: white;
    }
    .btn-login {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #1D4ED8;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: background 0.2s;
    }
    .btn-login:hover {
        background: #1363e2;
        color: white;
    }
    .btn-home {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #F3F4F6;
        color: #374151;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: background 0.2s;
    }
    .btn-home:hover {
        background: #E5E7EB;
        color: #111827;
    }
</style>

<div class="refused-wrapper">
    <div class="box">
        <div class="box-header">
            <i class="bi bi-x-circle"></i>
            <h1>Demande refusée</h1>
        </div>
        <div class="box-body">
            <div class="status-badge">
                <i class="bi bi-slash-circle"></i> Accès refusé
            </div>
            <p>
                Votre demande d'inscription a été examinée<br>
                et n'a pas été retenue par l'administration.<br>
                Pour toute question, veuillez contacter le centre.
            </p>
        </div>
        <div class="box-footer">
            <a href="{{ route('welcome') }}" class="btn-home">
                <i class="bi bi-house"></i> Accueil
            </a>
            <a href="{{ route('login') }}" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Connexion
            </a>
        </div>
    </div>
</div>
@endsection