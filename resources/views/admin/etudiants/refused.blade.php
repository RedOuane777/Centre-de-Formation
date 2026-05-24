@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Étudiants refusés
</h1>

@if(session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
</div>
@endif

<div class="d-flex flex-wrap gap-2 mb-3">
    <form action="{{ route('admin.etudiants.destroyRefusedAll') }}"
        method="POST"
        onsubmit="return confirm('Supprimer tous les étudiants refusés ?')">

        @csrf
        @method('DELETE')

        <button class="btn btn-danger">
            <i class="bi bi-trash me-1"></i> Supprimer tous
        </button>

    </form>
</div>

<form action="{{ route('admin.etudiants.refused') }}" method="GET"
    class="mb-3 d-flex flex-wrap align-items-center gap-2">

    <input type="text" name="search"
        class="form-control"
        placeholder="Rechercher par nom, prenom ou email"
        value="{{ request('search') }}"
        style="max-width: 400px;">

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Rechercher
    </button>

    <a href="{{ route('admin.etudiants.refused') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise me-1"></i> Reset
    </a>

</form>

<div class="table-wrapper shadow-wrapper">
    <div class="table-responsive shadow-sm rounded">

        <table class="table table-sm table-compact custom-table mb-0">

            <thead>
                <tr>
                    <th style="width:60px;">ID</th>
                    <th style="width:120px;">Nom</th>
                    <th style="width:120px;">Prénom</th>
                    <th style="width:200px;">Email</th>
                    <th style="width:100px;">Genre</th>
                    <th style="width:150px;">Filière</th>
                    <th style="width:120px;">Ville</th>
                    <th style="width:150px;">Date de naissance</th>
                </tr>
            </thead>

            <tbody>
                @forelse($etudiants as $etudiant)
                <tr>

                    <td title="{{ $etudiant->id }}">{{ $etudiant->id }}</td>

                    <td class="text-truncate" style="max-width:120px;" title="{{ $etudiant->user->nom }}">
                        {{ $etudiant->user->nom }}
                    </td>

                    <td class="text-truncate" style="max-width:120px;" title="{{ $etudiant->user->prenom }}">
                        {{ $etudiant->user->prenom }}
                    </td>

                    <td class="text-truncate" style="max-width:200px;" title="{{ $etudiant->user->email }}">
                        {{ $etudiant->user->email }}
                    </td>

                    <td>
                        {{ $etudiant->user->gender == 'male' ? 'Homme' : 'Femme' }}
                    </td>

                    <td class="text-truncate" style="max-width:150px;" title="{{ $etudiant->filiere->libelle }}">
                        {{ $etudiant->filiere->libelle }}
                    </td>

                    <td title="{{ $etudiant->ville }}">
                        {{ $etudiant->ville }}
                    </td>

                    <td title="{{ $etudiant->date_naissance }}">{{ $etudiant->date_naissance }}</td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-2">
                        <span class="text-muted">Aucun étudiant refusé</span>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

<style>
    .shadow-wrapper {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.10);
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }

    .custom-table thead th {
        background-color: #1D4ED8;
        color: white;
        font-weight: 600;
        border: none;
    }

    .custom-table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .custom-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .custom-table tbody tr:hover {
        background-color: #eef2ff;
        transition: 0.2s;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .badge {
        font-size: 0.8rem;
        font-weight: 500;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alertBox = document.getElementById('success-alert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.remove('show');
                alertBox.classList.add('fade');
                setTimeout(() => alertBox.remove(), 500);
            }, 5000);
        }
    });
</script>

@endsection