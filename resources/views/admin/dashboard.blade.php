@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Tableau de bord Admin
</h1>

<div class="row g-4">

    <div class="col-md-4">
        <a href="{{ route('admin.etudiants.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--primary-color);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Étudiants</h5>
                        <p class="card-text fs-2 counter" data-count="{{ $totalEtudiants ?? 0 }}">0</p>
                    </div>
                    <i class="bi bi-people-fill fs-1"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.enseignants.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--success-color);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Enseignants</h5>
                        <p class="card-text fs-2 counter" data-count="{{ $totalEnseignants ?? 0 }}">0</p>
                    </div>
                    <i class="bi bi-person-badge-fill fs-1"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.modules.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--warning-color);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Modules</h5>
                        <p class="card-text fs-2 counter" data-count="{{ $totalModules ?? 0 }}">0</p>
                    </div>
                    <i class="bi bi-journal-bookmark-fill fs-1"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.groupes.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--info-color);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Groupes</h5>
                        <p class="card-text fs-2 counter" data-count="{{ $totalGroupes ?? 0 }}">0</p>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.filieres.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--secondary-color);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Filières</h5>
                        <p class="card-text fs-2 counter" data-count="{{ $totalFilieres ?? 0 }}">0</p>
                    </div>
                    <i class="bi bi-book-fill fs-1"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.examens.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--error-color);">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Examens</h5>
                        <p class="card-text fs-2 counter" data-count="{{ $totalExamens ?? 0 }}">0</p>
                    </div>
                    <i class="bi bi-file-earmark-text-fill fs-1"></i>
                </div>
            </div>
        </a>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll('.counter');

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-count');
            let current = +counter.innerText;
            const increment = target / 100;

            if(current < target) {
                counter.innerText = Math.ceil(current + increment);
                setTimeout(updateCount,80);
            } else {
                counter.innerText = target;
            }
        };

        updateCount();
    });
});
</script>

@endsection