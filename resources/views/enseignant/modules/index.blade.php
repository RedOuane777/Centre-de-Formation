@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Mes Modules
</h1>

<div class="row">
@foreach($modules as $module)

    @php
        $groupes = $relations
            ->where('module_id', $module->id)
            ->pluck('groupe')
            ->filter();;
    @endphp

    <div class="col-md-6 col-lg-4">
        <div class="card mb-4 shadow-sm h-100 module-card">

            <div class="card-header border-bottom" style="background-color: #1844ba; color: #ffffff;">
                <strong>{{ $module->titre }}</strong>
            </div>

            <div class="card-body d-flex flex-column">

                <p class="text-muted small mb-2">
                    {{ $module->description }}
                </p>

                <div class="mb-2 small">
                    <strong>Heures:</strong> {{ $module->heures }}
                </div>

                <div class="mb-3 small">
                    <strong>Filière:</strong> {{ $module->filiere->libelle ?? 'N/A' }}
                </div>

                <div class="mt-auto">
                    <div class="small text-muted mb-1">Groupes</div>

                    @forelse($groupes as $groupe)
                        <span class="badge bg-light text-dark border me-1 mb-1">
                            {{ $groupe->libelle }}
                        </span>
                    @empty
                        <span class="text-muted small">Aucun</span>
                    @endforelse
                </div>

            </div>

        </div>
    </div>

@endforeach
</div>

<style>
.module-card {
    border-radius: 10px;
    transition: 0.2s ease;
}

.module-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.08);
}
</style>

@endsection