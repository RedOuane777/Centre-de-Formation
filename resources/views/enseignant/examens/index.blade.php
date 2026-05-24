@extends('layouts.app')

@section('content')
<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Liste des Examens
</h1>

<div class="table-wrapper shadow-wrapper">
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-sm table-compact custom-table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Module</th>
                    <th>Groupe</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th style="width:150px;">Heure</th>
                    <th>Salle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($examens as $examen)
                <tr>
                    <td title="{{ $examen->id }}">{{ $examen->id }}</td>
                    <td title="{{ $examen->moduleGroupeEnseignant->module->titre ?? '' }}">{{ $examen->moduleGroupeEnseignant->module->titre ?? '' }}</td>
                    <td title="{{ $examen->moduleGroupeEnseignant->groupe->libelle ?? '' }}">{{ $examen->moduleGroupeEnseignant->groupe->libelle ?? '' }}</td>
                    <td title="{{ $examen->dateE }}">{{ $examen->dateE }}</td>
                    <td title="{{ $examen->typeE }}">{{ $examen->typeE }}</td>
                    <td title="{{ $examen->heure_debut }} - {{ $examen->heure_fin }}">
                        {{ $examen->heure_debut }} - {{ $examen->heure_fin }}
                    </td>
                    <td title="{{ $examen->salle ?? '' }}">{{ $examen->salle ?? '' }}</td>
                    <td>
                        <a href="{{ route('enseignant.notes.edit', $examen->id) }}" class="btn btn-info btn-sm mb-1">
                            <i class="bi bi-pencil-square me-1"></i> Notes
                        </a>
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
        background-color: #1844ba;
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
@endsection