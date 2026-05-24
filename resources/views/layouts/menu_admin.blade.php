<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        href="{{ route('admin.dashboard') }}">Dashboard</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.etudiants.pending') ? 'active' : '' }}"
        href="{{ route('admin.etudiants.pending') }}">Etudiants en attente</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.etudiants.refused') ? 'active' : '' }}"
        href="{{ route('admin.etudiants.refused') }}">Etudiants refusés</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.etudiants.index') && !request()->routeIs('admin.etudiants.pending') ? 'active' : '' }}"
        href="{{ route('admin.etudiants.index') }}">Etudiants</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.enseignants.*') ? 'active' : '' }}"
        href="{{ route('admin.enseignants.index') }}">Enseignants</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.filieres.index') ? 'active' : '' }}"
        href="{{ route('admin.filieres.index') }}">Filieres</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.groupes.index') ? 'active' : '' }}"
        href="{{ route('admin.groupes.index') }}">Groupes</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.modules.index') ? 'active' : '' }}"
        href="{{ route('admin.modules.index') }}">Modules</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.examens.index') ? 'active' : '' }}"
        href="{{ route('admin.examens.index') }}">Examens</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.notes.index') ? 'active' : '' }}"
        href="{{ route('admin.notes.index') }}">Notes</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.seances.index') ? 'active' : '' }}"
        href="{{ route('admin.seances.index') }}">Seances</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.emploi.index') ? 'active' : '' }}"
        href="{{ route('admin.emploi.index') }}">Emploi du temps</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.documents.index') ? 'active' : '' }}"
        href="{{ route('admin.documents.index') }}">Documents</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.mge.index') ? 'active' : '' }}"
        href="{{ route('admin.mge.index') }}">MGE (Relations)</a>
</li>