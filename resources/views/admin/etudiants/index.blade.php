@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Liste des Étudiants
</h1>

@if(session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
</div>
@endif

<div class="d-flex flex-wrap gap-2 mb-3">
    <form action="{{ route('admin.etudiants.destroyAll') }}" method="POST"
        onsubmit="return confirm('Voulez-vous vraiment supprimer touts les étudiants ?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">
            <i class="bi bi-trash me-1"></i> Supprimer tous
        </button>
    </form>
</div>

<form action="{{ route('admin.etudiants.index') }}" method="GET"
    class="mb-3 d-flex flex-wrap align-items-center gap-2">

    <input type="text" name="search" class="form-control"
        placeholder="Rechercher par nom, prenom ou code"
        value="{{ request('search') }}"
        style="max-width: 400px;">

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Rechercher
    </button>

    <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise me-1"></i> Reset
    </a>
</form>

<div class="table-wrapper shadow-wrapper">
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-sm table-compact custom-table">
            <thead>
                <tr>
                    <th style="width:60px;">ID</th>
                    <th style="width:120px;">Nom</th>
                    <th style="width:120px;">Prénom</th>
                    <th style="width:90px;">Genre</th>
                    <th style="width:200px;">Email</th>
                    <th style="width:120px;">Code</th>
                    <th style="width:120px;">Ville</th>
                    <th style="width:150px;">Date de Naissance</th>
                    <th style="width:200px;">Filière</th>
                    <th style="width:110px;">Groupe</th>
                    <th style="width:250px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($etudiants as $etudiant)
                <tr>
                    <td title="{{ $etudiant->id }}">{{ $etudiant->id }}</td>
                    <td title="{{ $etudiant->user->nom }}">{{ $etudiant->user->nom }}</td>
                    <td title="{{ $etudiant->user->prenom }}">{{ $etudiant->user->prenom }}</td>
                    <td>{{ $etudiant->user->gender == 'male' ? 'Homme' : 'Femme' }}</td>
                    <td title="{{ $etudiant->user->email }}">{{ $etudiant->user->email }}</td>
                    <td title="{{ $etudiant->code_etud }}">{{ $etudiant->code_etud }}</td>
                    <td title="{{ $etudiant->ville }}">{{ $etudiant->ville }}</td>
                    <td title="{{ $etudiant->date_naissance }}">{{ $etudiant->date_naissance }}</td>
                    <td title="{{ $etudiant->filiere->libelle ?? '' }}">{{ $etudiant->filiere->libelle ?? '' }}</td>
                    <td title="{{ $etudiant->groupe->libelle ?? '' }}">{{ $etudiant->groupe->libelle ?? '' }}</td>
                    <td>
                        <a href="{{ route('admin.etudiants.edit', $etudiant->id) }}" class="btn btn-warning btn-sm mb-1">
                            <i class="bi bi-pencil-square me-1"></i> modifier
                        </a>
                        <form action="{{ route('admin.etudiants.destroy', $etudiant->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('Voulez-vous vraiment supprimer cet etudiant ?')">
                                <i class="bi bi-trash me-1"></i> supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .shadow-wrapper {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 6px;
        overflow: hidden;
    }

    .custom-table thead th {
        background-color: #1D4ED8;
        color: white;
        font-weight: 600;
    }

    .custom-table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .custom-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .text-truncate {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alertBox = document.getElementById('success-alert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.remove('show');
                alertBox.classList.add('fade');
                setTimeout(() => {
                    alertBox.remove();
                }, 500);
            }, 5000);
        }
    });
</script>

@endsection