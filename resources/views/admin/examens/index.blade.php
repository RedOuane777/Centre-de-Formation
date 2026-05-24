@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Liste des Examens
</h1>

@if(session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
</div>
@endif

<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('admin.examens.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Ajouter Examen
    </a>

    <form action="{{ route('admin.examens.destroyAll') }}" method="POST"
        onsubmit="return confirm('Voulez-vous vraiment supprimer touts les examens ?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">
            <i class="bi bi-trash me-1"></i> Supprimer tous
        </button>
    </form>
</div>

<form action="{{ route('admin.examens.index') }}" method="GET"
    class="mb-3 d-flex flex-wrap align-items-center gap-2">

    <input type="text" name="search" class="form-control"
        placeholder="Rechercher par module, groupe ou type"
        value="{{ request('search') }}"
        style="max-width: 400px;">

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Rechercher
    </button>

    <a href="{{ route('admin.examens.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise me-1"></i> Reset
    </a>
</form>

<div class="table-wrapper shadow-wrapper">
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-sm table-compact custom-table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="width:150px;">Module</th>
                    <th style="width:200px;">Enseignant</th>
                    <th style="width:150px;">Groupe</th>
                    <th style="width:200px;">Date</th>
                    <th style="width:100px;">Type</th>
                    <th style="width:200px;">Heure</th>
                    <th style="width:150px;">Salle</th>
                    <th style="width:300px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($examens as $examen)
                <tr>
                    <td title="{{ $examen->id }}">{{ $examen->id }}</td>
                    <td title="{{ $examen->moduleGroupeEnseignant->module->titre ?? '' }}">
                        {{ $examen->moduleGroupeEnseignant->module->titre ?? '' }}
                    </td>

                    <td title="{{ $examen->moduleGroupeEnseignant->enseignant->user->prenom ?? '' }} {{ $examen->moduleGroupeEnseignant->enseignant->user->nom ?? '' }}">
                        {{ $examen->moduleGroupeEnseignant->enseignant->user->prenom ?? '' }}
                        {{ $examen->moduleGroupeEnseignant->enseignant->user->nom ?? '' }}
                    </td>

                    <td title="{{ $examen->moduleGroupeEnseignant->groupe->libelle ?? '' }}">
                        {{ $examen->moduleGroupeEnseignant->groupe->libelle ?? '' }}
                    </td>
                    <td title="{{ $examen->dateE }}">{{ $examen->dateE }}</td>
                    <td title="{{ $examen->typeE }}">{{ $examen->typeE }}</td>
                    <td title="{{ $examen->heure_debut }} - {{ $examen->heure_fin }}">
                        {{ $examen->heure_debut }} - {{ $examen->heure_fin }}
                    </td>
                    <td title="{{ $examen->salle }}">{{ $examen->salle }}</td>
                    <td>
                        <a href="{{ route('admin.examens.edit', $examen->id) }}" class="btn btn-warning btn-sm mb-1">
                            <i class="bi bi-pencil-square me-1"></i> Modifier
                        </a>
                        <a href="{{ route('admin.notes.create', $examen->id) }}" class="btn btn-info btn-sm mb-1">
                            <i class="bi bi-pencil-square me-1"></i> Notes
                        </a>
                        <form action="{{ route('admin.examens.destroy', $examen->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('Voulez-vous vraiment supprimer cet examen ?')">
                                <i class="bi bi-trash me-1"></i> Supprimer
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