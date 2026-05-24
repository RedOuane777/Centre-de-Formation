@extends('layouts.app')

@section('content')

<h2 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 1.8rem;">
    Ajouter un Groupe
</h2>

@if ($errors->any())
<div class="alert alert-danger shadow-sm">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow-sm border-0 rounded-lg" style="background-color: #f9fafb; max-width: 800px;">
    <div class="card-body">

        <form action="{{ route('admin.groupes.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="libelle" class="form-label">Libellé du Groupe</label>
                <input type="text" id="libelle" name="libelle" class="form-control shadow-sm" required>
            </div>

            <div class="mb-3">
                <label for="filiere_id" class="form-label">Filière</label>
                <select name="filiere_id" id="filiere_id" class="form-select shadow-sm" required>
                    <option value="">-- Sélectionner une filière --</option>
                    @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.groupes.index') }}" class="btn btn-secondary shadow-sm">Annuler</a>
                <button type="submit" class="btn btn-success shadow-sm">
                    <i class="bi bi-check-circle me-1"></i>
                    Enregistrer
                </button>
            </div>

        </form>

    </div>
</div>


@endsection