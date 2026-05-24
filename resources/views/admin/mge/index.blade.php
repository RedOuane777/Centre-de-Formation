@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Relations MGE
</h1>

<form action="{{ route('admin.mge.index') }}" method="GET"
    class="mb-3 d-flex flex-wrap align-items-center gap-2">

    <input type="text" name="search" class="form-control"
        placeholder="Rechercher par module, groupe ou enseignant"
        value="{{ request('search') }}"
        style="max-width: 400px;">

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Rechercher
    </button>

    <a href="{{ route('admin.mge.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise me-1"></i> Reset
    </a>
</form>

@if(session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
</div>
@endif

<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('admin.mge.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Ajouter Relation
    </a>
</div>

<div class="table-wrapper shadow-wrapper">
    <div class="table-responsive shadow-sm rounded">

        <table class="table table-sm table-compact custom-table mb-0">

            <thead>
                <tr>
                    <th style="width:80px;">ID</th>
                    <th style="width:200px;">Module</th>
                    <th style="width:200px;">Groupe</th>
                    <th style="width:250px;">Enseignant</th>
                    <th style="width:200px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($relations as $rel)
                <tr>

                    <td title="{{ $rel->id }}">{{ $rel->id }}</td>

                    <td class="text-truncate" style="max-width:200px;" title="{{ $rel->module?->titre }}">
                        {{ $rel->module?->titre ?? 'Non attribué' }}
                    </td>

                    <td class="text-truncate" style="max-width:200px;" title="{{ $rel->groupe?->libelle }}">
                        {{ $rel->groupe?->libelle ?? 'Non attribué' }}
                    </td>

                    <td class="text-truncate" style="max-width:250px;" title="{{ $rel->enseignant->user->prenom }} {{ $rel->enseignant->user->nom }}">
                        @if($rel->enseignant && $rel->enseignant->user)
                        {{ $rel->enseignant->user->prenom }} {{ $rel->enseignant->user->nom }}
                        @else
                        Non attribué
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.mge.edit', $rel->id) }}"
                            class="btn btn-warning btn-sm mb-1">
                            <i class="bi bi-pencil-square me-1"></i> Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.mge.destroy', $rel->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm mb-1"
                                onclick="return confirm('Voulez-vous vraiment supprimer cette relation ?')">
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

    .text-truncate {
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
                setTimeout(() => alertBox.remove(), 500);
            }, 5000);
        }
    });
</script>

@endsection