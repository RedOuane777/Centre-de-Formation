<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}" 
       href="{{ route('etudiant.dashboard') }}">Dashboard</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('etudiant.modules.*') ? 'active' : '' }}" 
       href="{{ route('etudiant.modules.index') }}">Modules</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('etudiant.emploi') ? 'active' : '' }}" 
       href="{{ route('etudiant.emploi') }}">Emploi du temps</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('etudiant.examens.*') ? 'active' : '' }}" 
       href="{{ route('etudiant.examens.index') }}">Examens</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('etudiant.notes.*') ? 'active' : '' }}" 
       href="{{ route('etudiant.notes.index') }}">Notes</a>
</li>