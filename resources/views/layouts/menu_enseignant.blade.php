<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}" 
       href="{{ route('enseignant.dashboard') }}">Dashboard</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('enseignant.modules.*') ? 'active' : '' }}" 
       href="{{ route('enseignant.modules.index') }}">Modules</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('enseignant.emploi') ? 'active' : '' }}" 
       href="{{ route('enseignant.emploi') }}">Emploi du temps</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('enseignant.groupes.*') ? 'active' : '' }}" 
       href="{{ route('enseignant.groupes.index') }}">Groupes</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('enseignant.examens.*') ? 'active' : '' }}" 
       href="{{ route('enseignant.examens.index') }}">Examens</a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('enseignant.notes.*') ? 'active' : '' }}" 
       href="{{ route('enseignant.notes.index') }}">Notes</a>
</li>