@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Liste des Documents
</h1>

<form action="{{ route('admin.documents.index') }}" method="GET"
    class="mb-3 d-flex flex-wrap align-items-center gap-2">

    <input type="text" name="search" class="form-control"
        placeholder="Rechercher nom, prénom, filière ou groupe"
        value="{{ request('search') }}"
        style="max-width: 400px;">

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Rechercher
    </button>

    <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise me-1"></i> Reset
    </a>
</form>

<p>Choisissez un étudiant pour générer les documents :</p>

<div class="table-wrapper shadow-wrapper">
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-sm table-compact custom-table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom & Prénom</th>
                    <th>Filière</th>
                    <th>Groupe</th>
                    <th style="width:280px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($etudiants as $index => $e)
                <tr>
                    <td title="{{ $index + 1 }}">{{ $index + 1 }}</td>
                    <td title="{{ $e->user->nom ?? '' }} {{ $e->user->prenom ?? '' }}">{{ $e->user->nom ?? '' }} {{ $e->user->prenom ?? '' }}</td>
                    <td title="{{ $e->filiere->libelle ?? 'N/A' }}">{{ $e->filiere->libelle ?? 'N/A' }}</td>
                    <td title="{{ $e->groupe->libelle ?? 'N/A' }}">{{ $e->groupe->libelle ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.documents.attestation', $e->id) }}" class="btn btn-sm btn-primary" target="_blank">
                            <i class="bi bi-file-earmark-text me-1"></i> Attestation
                        </a>
                        <a href="{{ route('admin.documents.releve', $e->id) }}" class="btn btn-sm btn-success" target="_blank">
                            <i class="bi bi-file-earmark-text me-1"></i> Relevé de Notes
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

@endsection