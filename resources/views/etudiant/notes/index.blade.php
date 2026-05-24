@extends('layouts.app')

@section('content')

<style>
    .module-card {
        border-left: 4px solid #4d78ed;
    }

    .table-highlight {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table-highlight th {
        background-color: #1844ba;
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

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Mes Notes
</h1>

<form action="{{ route('etudiant.notes.index') }}" method="GET"
    class="mb-3 d-flex flex-wrap align-items-center gap-2">

    <input type="text" name="search" class="form-control"
        placeholder="Rechercher par module"
        value="{{ request('search') }}"
        style="max-width: 400px;">

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Rechercher
    </button>

    <a href="{{ route('etudiant.notes.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise me-1"></i> Reset
    </a>
</form>

@foreach($modules as $moduleName => $examens)

@php
    $colors = ['#f9fafb', '#f3f4f6'];
    $bg = $colors[$loop->index % 2];
@endphp

<div class="card mb-5 shadow-sm rounded-lg module-card" style="background-color: {{ $bg }};">

    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <div>
            <strong>Module :</strong>
            <span class="ms-2">{{ $moduleName }}</span>
        </div>
    </div>

    <div class="card-body pt-2">
        <div class="table-responsive">
            <table class="table table-compact table-sm align-middle mb-0 table-highlight">
                <thead>
                    <tr>
                        <th>Type Examen</th>
                        <th>Date</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($examens as $examen)
                    @php
                        $note = $examen->notes
                            ->where('etudiant_id', $etudiant->id)
                            ->first();
                    @endphp
                    <tr>
                        <td>{{ $examen->typeE }}</td>
                        <td>{{ $examen->dateE }}</td>
                        <td>{{ $note->noteE ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endforeach

@endsection