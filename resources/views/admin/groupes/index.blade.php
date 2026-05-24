@extends('layouts.app')

@section('content')
<h1 class="mb-4" style="color: var(--text-dark); font-weight: 600; font-size: 2rem;">
    Liste des Groupes
</h1>

@if(session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
</div>
@endif

<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('admin.groupes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Ajouter Groupe
    </a>

    <form action="{{ route('admin.groupes.destroyAll') }}" method="POST"
        onsubmit="return confirm('Voulez-vous vraiment supprimer touts les groupes ?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">
            <i class="bi bi-trash me-1"></i> Supprimer tous
        </button>
    </form>
</div>

<form action="{{ route('admin.groupes.index') }}" method="GET"
    class="mb-3 d-flex flex-wrap align-items-center gap-2">

    <input type="text" name="search" class="form-control"
        placeholder="Rechercher par groupe, filières"
        value="{{ request('search') }}"
        style="max-width: 400px;">

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search me-1"></i> Rechercher
    </button>

    <a href="{{ route('admin.groupes.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-clockwise me-1"></i> Reset
    </a>
</form>

<div class="table-wrapper shadow-wrapper">
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-sm table-compact custom-table mb-0">
            <thead>
                <tr>
                    <th style="width:120px;">ID</th>
                    <th style="width:210px;">Libellé</th>
                    <th>Filière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupes as $groupe)
                <tr>
                    <td title="{{ $groupe->id }}">{{ $groupe->id }}</td>
                    <td title="{{ $groupe->libelle }}">{{ $groupe->libelle }}</td>
                    <td title="{{ $groupe->filiere->libelle }}">{{ $groupe->filiere->libelle }}</td>
                    <td>
                        <a href="{{ route('admin.groupes.edit', $groupe->id) }}" class="btn btn-warning btn-sm mb-1">
                            <i class="bi bi-pencil-square me-1"></i> Modifier
                        </a>

                        <button
                            class="btn btn-info btn-sm mb-1 btn-voir"
                            data-libelle="{{ $groupe->libelle }}"
                            data-etudiants='@json($groupe->etudiants->map(fn($e) => [
                                            "nom" => $e->user->nom,
                                            "prenom" => $e->user->prenom,
                                            "email" => $e->user->email
                                        ]))'>
                            <i class="bi bi-eye me-1"></i> Voir
                        </button>

                        <form action="{{ route('admin.groupes.destroy', $groupe->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('Voulez-vous vraiment supprimer cet groupe ?')">
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
<div class="modal fade" id="modalEtudiants" tabindex="-1">
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
                    Nombre d’étudiants: <strong id="modal-count">0</strong>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody id="modal-body-content">
                        </tbody>
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
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alertBox = document.getElementById('success-alert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.remove('show');
                alertBox.classList.add('fade');
                setTimeout(() => {
                    alertBox.remove();
                }, 500);
            }, 5000);
        }
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.btn-voir').forEach(button => {
        button.addEventListener('click', function () {

            let etudiants = JSON.parse(this.getAttribute('data-etudiants') || '[]');
            let groupeName = this.getAttribute('data-libelle');

            let tbody = document.getElementById('modal-body-content');
            let count = document.getElementById('modal-count');
            let title = document.getElementById('modal-groupe-name');
            let emptyState = document.getElementById('empty-state');

            tbody.innerHTML = '';

            title.textContent = groupeName;

            count.textContent = etudiants.length;

            if (etudiants.length === 0) {
                emptyState.classList.remove('d-none');
            } else {
                emptyState.classList.add('d-none');

                etudiants.forEach(e => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${e.nom}</td>
                            <td>${e.prenom}</td>
                            <td class="text-muted">${e.email}</td>
                        </tr>
                    `;
                });
            }

            let modal = new bootstrap.Modal(document.getElementById('modalEtudiants'));
            modal.show();
        });
    });

});
</script>

@endsection