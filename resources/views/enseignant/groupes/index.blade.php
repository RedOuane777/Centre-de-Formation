@extends('layouts.app')

@section('content')

<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Mes Groupes
</h1>

<div class="row">
    @foreach($groupes as $groupe)
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center">
                <h5 class="fw-bold">{{ $groupe->libelle }}</h5>

                <button
                    class="btn btn-custom-green mt-2 btn-show-students"
                    data-id="{{ $groupe->id }}"
                    data-libelle="{{ $groupe->libelle }}">
                    Voir étudiants
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>

<div class="modal fade" id="studentsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">

            <div class="modal-header text-white" style="background-color : #1D4ED8">
                <h5 class="modal-title">
                    <i class="bi bi-people-fill me-2"></i>
                    <span id="modal-groupe-name">Groupe</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3 text-muted">
                    Nombre d’étudiants : <strong id="modal-count">0</strong>
                </div>

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

<style>
    .btn-custom-green {
        border: 1px solid #1844ba;
        color: #1844ba;
        background: transparent;
    }

    .btn-custom-green:hover {
        background: #1844ba;
        color: #fff;
    }
</style>
<script>
    document.querySelectorAll('.btn-show-students').forEach(button => {

        button.addEventListener('click', function() {

            let groupeId = this.dataset.id;
            let groupeName = this.dataset.libelle;

            let tbody = document.getElementById('modal-body-content');
            let count = document.getElementById('modal-count');
            let title = document.getElementById('modal-groupe-name');
            let emptyState = document.getElementById('empty-state');

            tbody.innerHTML = '';

            title.textContent = groupeName;

            fetch(`/enseignant/groupes/${groupeId}/etudiants`)
                .then(res => res.json())
                .then(data => {

                    count.textContent = data.length;

                    if (data.length === 0) {
                        emptyState.classList.remove('d-none');
                    } else {
                        emptyState.classList.add('d-none');

                        data.forEach(e => {
                            tbody.innerHTML += `
                        <tr>
                            <td>${e.user.nom}</td>
                            <td>${e.user.prenom}</td>
                        </tr>
                    `;
                        });
                    }

                    let modal = new bootstrap.Modal(document.getElementById('studentsModal'));
                    modal.show();
                });

        });

    });
</script>

@endsection