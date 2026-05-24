@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Mes Examens
</h1>

@if($examens->isEmpty())

    <div class="alert alert-light border">
        Aucun examen prévu pour votre groupe.
    </div>

@else

<div class="container" style="max-width: 900px;">

@foreach($examens as $moduleTitre => $moduleExamens)

    <div class="card mb-4 shadow-sm">

        <div class="card-header border-0"
             style="background-color: #1844ba; color: #ffffff; font-weight: 600;">
            {{ $moduleTitre }}
        </div>

        <div class="card-body">

            <div class="row">

                @foreach($moduleExamens as $examen)

                    <div class="col-md-6 mb-3">

                        <div class="p-3 rounded shadow-sm h-100"
                             style="background-color: #f8fafc; border-left: 4px solid #4d78ed;">

                            <div class="mb-2">
                                <strong>{{ $examen->typeE }}</strong>
                            </div>

                            <div class="text-muted small mb-1">
                                Date :
                                {{ \Carbon\Carbon::parse($examen->dateE)->format('d/m/Y') }}
                            </div>

                            <div class="text-muted small">
                                Salle : {{ $examen->salle ?? 'Non attribué' }}
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>
    </div>

@endforeach

</div>

@endif

@endsection