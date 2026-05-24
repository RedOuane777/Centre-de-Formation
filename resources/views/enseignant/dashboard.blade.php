@extends('layouts.app')

@section('content')
<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Tableau de bord Enseignant
</h1>

<div class="row g-4">

    {{-- Modules --}}
    <div class="col-md-4">
        <a href="{{ route('enseignant.modules.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--warning-color); cursor: pointer;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Modules</h5>
                        <p class="card-text fs-2 counter" data-count="{{ $modules_count ?? 0 }}">0</p>
                    </div>
                    <i class="bi bi-journal-bookmark-fill fs-1"></i>
                </div>
            </div>
        </a>
    </div>

    {{-- Groupes --}}
    <div class="col-md-4">
        <a href="{{ route('enseignant.groupes.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--info-color); cursor: pointer;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Groupes</h5>
                        <p class="card-text fs-2 counter" data-count="{{ $groupes_count ?? 0 }}">0</p>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </a>
    </div>

    {{-- Examens --}}
    <div class="col-md-4">
        <a href="{{ route('enseignant.examens.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--error-color); cursor: pointer;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Examens</h5>
                        <p class="card-text fs-2 counter" data-count="{{ $examens_count ?? 0 }}">0</p>
                    </div>
                    <i class="bi bi-file-earmark-text-fill fs-1"></i>
                </div>
            </div>
        </a>
    </div>

</div>

{{-- JavaScript للعداد الديناميكي --}}
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
                setTimeout(updateCount, 80);
            } else {
                counter.innerText = target;
            }
        };

        updateCount();
    });
});
</script>
@endsection