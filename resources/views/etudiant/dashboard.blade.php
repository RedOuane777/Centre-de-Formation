@extends('layouts.app')

@section('content')
<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Tableau de bord Etudiant
</h1>

<div class="row g-4">

    {{-- Groupe --}}
    <div class="col-md-4">
        <div class="card text-white h-100"
            style="background-color: var(--success-color); cursor: pointer;"
            id="btn-show-groupe"
            data-id="{{ $groupe->id ?? '' }}"
            data-libelle="{{ $groupe->libelle ?? '' }}">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Groupe</h5>
                    <p class="card-text fs-2">
                        {{ $groupe->libelle ?? 'Non attribué' }}
                    </p>
                </div>
                <i class="bi bi-people-fill fs-1"></i>
            </div>
        </div>
    </div>

    {{-- Modules --}}
    <div class="col-md-4">
        <a href="{{ route('etudiant.modules.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--primary-color); cursor: pointer;">
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

    {{-- Examens --}}
    <div class="col-md-4">
        <a href="{{ route('etudiant.examens.index') }}" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--warning-color); cursor: pointer;">
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

<div class="modal fade" id="studentsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow border-0" style="border-radius: 14px; overflow: hidden;">

            <div class="modal-header border-0 text-white" style="background-color : #1D4ED8">
                <h5 class="modal-title">
                    <i class="bi bi-people-fill me-2"></i>
                    <span id="modal-groupe-name"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 py-3">
                <p class="text-muted mb-3" style="font-size: 0.9rem;">
                    Nombre d'étudiants : <strong id="modal-count">0</strong>
                </p>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                            </tr>
                        </thead>
                        <tbody id="modal-body-content"></tbody>
                    </table>
                </div>

                <div id="empty-state" class="text-center text-muted py-4 d-none">
                    <i class="bi bi-emoji-frown fs-1"></i>
                    <p class="mt-2">Aucun étudiant dans ce groupe</p>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('.counter').forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-count');
                let current = +counter.innerText;
                const increment = target / 100;
                if (current < target) {
                    counter.innerText = Math.ceil(current + increment);
                    setTimeout(updateCount, 80);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });

        const btn = document.getElementById('btn-show-groupe');
        if (btn && btn.dataset.id) {
            btn.addEventListener('click', function() {
                let groupeId = this.dataset.id;
                let groupeName = this.dataset.libelle;

                document.getElementById('modal-groupe-name').textContent = groupeName;
                document.getElementById('modal-body-content').innerHTML = '';
                document.getElementById('modal-count').textContent = '0';
                document.getElementById('empty-state').classList.add('d-none');

                fetch(`/etudiant/groupes/${groupeId}/etudiants`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('modal-count').textContent = data.length;

                        if (data.length === 0) {
                            document.getElementById('empty-state').classList.remove('d-none');
                        } else {
                            data.forEach(e => {
                                document.getElementById('modal-body-content').innerHTML += `
                                <tr>
                                    <td>${e.user.nom}</td>
                                    <td>${e.user.prenom}</td>
                                </tr>`;
                            });
                        }

                        new bootstrap.Modal(document.getElementById('studentsModal')).show();
                    });
            });
        }
    });
</script>
@endsection