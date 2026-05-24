@extends('layouts.app')

@section('content')

<h2 class="mb-4">Modifier les notes - Examen #{{ $examen->id }}</h2>

@if($etudiants->isEmpty())
    <div class="alert alert-warning">
        Aucun étudiant disponible pour cet examen.
    </div>
@else
<form action="{{ route('enseignant.notes.store', $examen->id) }}" method="POST">
    @csrf

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Note</th>
            </tr>
        </thead>

        <tbody>
            @foreach($etudiants as $etudiant)
            <tr>
                <td>{{ $etudiant->user->nom }}</td>
                <td>{{ $etudiant->user->prenom }}</td>
                <td>
                    <input type="number" 
                           name="notes[{{ $etudiant->id }}]" 
                           value="{{ $etudiant->notes->where('examen_id', $examen->id)->first()?->noteE ?? '' }}" 
                           step="0.01" 
                           min="0" max="20"
                           class="form-control" >
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <button class="btn btn-success">Enregistrer les notes</button>
        <a href="{{ route('enseignant.examens.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</form>
@endif

@endsection