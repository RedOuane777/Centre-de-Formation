@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Liste des Séances
</h1>

@if(session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
</div>
@endif

<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('admin.seances.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Ajouter Séance
    </a>

    <form action="{{ route('admin.seances.destroyAll') }}" method="POST"
        onsubmit="return confirm('Voulez-vous vraiment supprimer touts les séances ?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">
            <i class="bi bi-trash me-1"></i> Supprimer tous
        </button>
    </form>
</div>

<div class="table-wrapper shadow-wrapper">
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-sm table-compact custom-table mb-0">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Groupe</th>
                    <th>Enseignant</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Salle</th>
                    <th style="width:250px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($seances as $seance)
                <tr>
                    <td title="{{ $seance->moduleGroupeEnseignant->module->titre ?? '' }}">
                        @if($seance->moduleGroupeEnseignant)
                        {{ $seance->moduleGroupeEnseignant->module->titre ?? '⚠ Module missing' }}
                        @else
                        ⚠ MGE missing
                        @endif
                    </td>
                    <td title="{{ $seance->moduleGroupeEnseignant->groupe->libelle ?? '' }}">
                        @if($seance->moduleGroupeEnseignant)
                        {{ $seance->moduleGroupeEnseignant->groupe->libelle ?? '⚠ Group missing' }}
                        @else
                        ⚠ MGE missing
                        @endif
                    </td>
                    <td title="{{ $seance->moduleGroupeEnseignant->enseignant->user->nom }} {{ $seance->moduleGroupeEnseignant->enseignant->user->prenom }}">
                        @if($seance->moduleGroupeEnseignant && $seance->moduleGroupeEnseignant->enseignant && $seance->moduleGroupeEnseignant->enseignant->user)
                        {{ $seance->moduleGroupeEnseignant->enseignant->user->nom }}
                        {{ $seance->moduleGroupeEnseignant->enseignant->user->prenom }}
                        @else
                        ⚠ Teacher/User missing
                        @endif
                    </td>
                    <td title="{{ $seance->date }}">{{ $seance->date }}</td>
                    <td title="{{ $seance->heure_debut }} - {{ $seance->heure_fin }}">{{ $seance->heure_debut }} - {{ $seance->heure_fin }}</td>
                    <td title="{{ $seance->salle }}">{{ $seance->salle }}</td>
                    <td>
                        <a href="{{ route('admin.seances.edit', $seance->id) }}" class="btn btn-warning btn-sm mb-1">
                            <i class="bi bi-pencil-square me-1"></i> Modifier
                        </a>
                        <form action="{{ route('admin.seances.destroy', $seance->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('Voulez-vous vraiment supprimer cette séance ?')">
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