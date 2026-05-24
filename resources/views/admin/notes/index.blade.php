@extends('layouts.app')

@section('content')

<style>
    .exam-card {
        border-left: 4px solid #3B82F6;
    }

    .table-highlight {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table-highlight th {
        background-color: #1D4ED8;
        color: white;
    }

    .table-highlight tr:hover {
        background-color: transparent;
    }

    .table-highlight tbody tr:nth-child(odd) {
        background-color: #f8f9fa;
    }

    .table-highlight tbody tr:nth-child(even) {
        background-color: #ffffff;
    }
</style>

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600;">
    Notes des Examens
</h1>

<form action="{{ route('admin.notes.index') }}" method="GET"
    class="mb-3 d-flex flex-wrap align-items-center gap-2">

    <input type="text" name="search" class="form-control"
        placeholder="Rechercher par module ou groupe"
        value="{{ request('search') }}"
        style="max-width: 400px;">

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Rechercher
    </button>

    <a href="{{ route('admin.notes.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise me-1"></i> Reset
    </a>
</form>

@if(session('success'))
<div class="alert alert-success shadow-sm">
    {{ session('success') }}
</div>
@endif

@foreach($examens as $examen)

@php
$colors = ['#f9fafb', '#f3f4f6'];
$bg = $colors[$loop->index % 2];
@endphp

<div class="card mb-5 shadow-sm rounded-lg exam-card"
    style="background-color: {{ $bg }};">

    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <div>
            <strong>Examen #{{ $examen->id }}</strong>
            <span class="text-muted ms-2">
                {{ $examen->moduleGroupeEnseignant->module->titre ?? '' }}
            </span>
        </div>

        <div class="text-muted small">
            {{ $examen->dateE }} | {{ $examen->typeE }}
        </div>
    </div>

    <div class="px-3 pt-2 pb-1 text-muted small">
        Groupe : <strong>{{ $examen->moduleGroupeEnseignant->groupe->libelle ?? '' }}</strong>
    </div>

    <div class="card-body pt-2">

        @if(!$examen->moduleGroupeEnseignant->groupe || $examen->moduleGroupeEnseignant->groupe->etudiants->isEmpty())

        <div class="alert alert-warning shadow-sm mb-0">
            Aucun étudiant disponible pour cet examen.
        </div>

        @else

        <div class="table-responsive">
            <table class="table table-compact table-sm align-middle mb-0 table-highlight">
                <thead>
                    <tr>
                        <th style="width: 35%;">Nom</th>
                        <th style="width: 35%;">Prénom</th>
                        <th style="width: 30%;">Note</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($examen->moduleGroupeEnseignant->groupe->etudiants as $etudiant)
                    @php
                    $note = $etudiant->notes
                    ->where('examen_id', $examen->id)
                    ->first()?->noteE;
                    @endphp
                    <tr>
                        <td>{{ $etudiant->user->nom }}</td>
                        <td>{{ $etudiant->user->prenom }}</td>
                        <td>{{ $note ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        @endif

    </div>
</div>

@endforeach

@endsection