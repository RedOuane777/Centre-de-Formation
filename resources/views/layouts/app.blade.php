<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre de Formation</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">

    <style>
        :root {
            --primary-color: #1D4ED8;
            --secondary-color: #3B82F6;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --error-color: #EF4444;
            --info-color: #0EA5E9;
            --bg-light: #F3F4F6;
            --text-dark: #111827;
            --text-muted: #6B7280;
        }

        .btn {
            border-radius: 6px;
            transition: background-color 0.15s ease, box-shadow 0.15s ease;
        }

        .btn:hover {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-sm {
            border-radius: 5px;
            padding: 4px 8px;
        }

        .table-compact {
            table-layout: fixed;
            width: 100%;
        }

        .table-compact td,
        .table-compact th {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table-compact.table-sm td,
        .table-compact.table-sm th {
            padding: 6px 8px;
            font-size: 14px;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
        }

        .navbar {
            background: linear-gradient(90deg, #0B2A5B, #1844ba);
            padding: 6px 30px;
            margin-bottom: 0 !important;
        }

        .navbar .btn-danger {
            border-radius: 20px;
        }

        .sidebar {
            background-color: #f8fafc;
            height: 100vh;
            border-right: 1px solid #dee2e6;
            padding: 20px;
        }

        .sidebar h5 {
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .sidebar .nav-link {
            color: var(--text-dark);
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .content {
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            min-height: 85vh;
        }

        table th {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: 600;
        }

        table tr:hover {
            background-color: #e0e7ff;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
            color: #fff;
        }

        .btn-danger {
            background-color: var(--error-color);
            border-color: var(--error-color);
        }

        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .togglePassword {
            background: white !important;
            border-color: #dee2e6 !important;
            border-left: 0 !important;
        }

        .togglePassword:hover {
            background: #f9fafb !important;
            border-color: #dee2e6 !important;
            box-shadow: none !important;
        }

        .dropdown-toggle::after {
            border-top-color: white !important;
            border-color: white transparent transparent transparent !important;
        }

        .dropdown-item {
            transition: background-color 0.15s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus,
        .dropdown-item:active {
            background-color: #F3F4F6 !important;
            color: #374151 !important;
        }

        .dropdown-item.text-danger:hover,
        form .dropdown-item:hover {
            background-color: #FEF2F2 !important;
            color: #EF4444 !important;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a href="
                @auth
                    @if(auth()->user()->role == 'admin')
                        {{ route('admin.dashboard') }}
                    @elseif(auth()->user()->role == 'enseignant')
                        {{ route('enseignant.dashboard') }}
                    @elseif(auth()->user()->role == 'etudiant')
                        {{ route('etudiant.dashboard') }}
                    @endif
                @else
                    {{ url('/') }}
                @endauth" class="navbar-brand">
                <img src="{{ asset('images/centreformation.png') }}" style="width: 180px; height: 50px">
            </a>

            @auth
            <div class="dropdown me-3">
                <div class="d-flex align-items-center gap-2" data-bs-toggle="dropdown" style="cursor:pointer;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-person-fill" style="font-size: 1.1rem; color: white;"></i>
                    </div>
                    <span class="text-white" style="font-size: 0.9rem; font-weight: 500;">
                        {{ auth()->user()->nom }} {{ auth()->user()->prenom }}
                    </span>
                    <i class="bi bi-chevron-down text-white" style="font-size: 0.75rem;"></i>
                </div>

                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width: 200px; border-radius: 10px; overflow: hidden;">
                    <li class="px-3 py-2" style="background: #f8fafc; border-bottom: 1px solid #e5e7eb;">
                        <p class="mb-0 fw-semibold" style="font-size: 0.9rem; color: #111827;">
                            {{ auth()->user()->nom }} {{ auth()->user()->prenom }}
                        </p>
                        <p class="mb-0" style="font-size: 0.78rem; color: #6B7280;">
                            {{ auth()->user()->email }}
                        </p>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#profileModal"
                            style="font-size: 0.9rem; color: #374151;">
                            <i class="bi bi-shield-lock me-2" style="color: #1D4ED8;"></i> Sécurité du compte
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item py-2" style="font-size: 0.9rem; color: #EF4444;">
                                <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </nav>

    <div class="modal fade" id="profileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0" style="border-radius: 14px; overflow: hidden;">

                <div class="modal-header border-0 px-4 pt-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #EFF6FF; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-shield-lock-fill" style="font-size: 1.2rem; color: #1D4ED8;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" style="color: #111827;">Sécurité du compte</h5>
                            <p class="mb-0" style="font-size: 0.8rem; color: #6B7280;">Modifiez votre mot de passe</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('change.password') }}">
                    @csrf
                    <div class="modal-body px-4 py-3">

                        @if(session('password_error'))
                        <div class="alert alert-danger rounded-3 py-2" style="font-size: 0.88rem;">{{ session('password_error') }}</div>
                        @endif
                        @if(session('password_changed'))
                        <div class="alert alert-success rounded-3 py-2" style="font-size: 0.88rem;">{{ session('password_changed') }}</div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger rounded-3 py-2" style="font-size: 0.88rem;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-500" style="font-size: 0.88rem; color: #374151;">Mot de passe actuel</label>
                            <div class="input-group shadow-sm">
                                <input type="password" name="current_password" id="current_password" class="form-control" style="border-right: 0;" required>
                                <button type="button" class="btn btn-outline-secondary togglePassword" data-target="current_password" style="border-left: 0;">
                                    <i class="bi bi-eye" style="color: #6B7280;"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.88rem; color: #374151;">Nouveau mot de passe</label>
                            <div class="input-group shadow-sm">
                                <input type="password" name="new_password" id="new_password" class="form-control" style="border-right: 0;" required>
                                <button type="button" class="btn btn-outline-secondary togglePassword" data-target="new_password" style="border-left: 0;">
                                    <i class="bi bi-eye" style="color: #6B7280;"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-1">
                            <label class="form-label" style="font-size: 0.88rem; color: #374151;">Confirmation</label>
                            <div class="input-group shadow-sm">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" style="border-right: 0;" required>
                                <button type="button" class="btn btn-outline-secondary togglePassword" data-target="new_password_confirmation" style="border-left: 0;">
                                    <i class="bi bi-eye" style="color: #6B7280;"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer border-0 px-4 pb-4 gap-2">
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Modifier
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-2 sidebar">
                <h5>Menu</h5>
                <ul class="nav flex-column">
                    @auth
                    @if(auth()->user()->role == 'admin')
                    @include('layouts.menu_admin')

                    @elseif(auth()->user()->role == 'enseignant')
                    @include('layouts.menu_enseignant')

                    @elseif(auth()->user()->role == 'etudiant')
                    @include('layouts.menu_etudiant')
                    @endif
                    @endauth
                </ul>
            </div>

            <div class="col-md-10 content">
                @yield('content')
            </div>

        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('password_changed') || session('password_error'))
            var myModal = new bootstrap.Modal(document.getElementById('profileModal'));
            myModal.show();
            @endif
        });
    </script>

    <script>
        document.querySelectorAll('.togglePassword').forEach(function(btn) {
            btn.addEventListener('click', function() {
                let input = document.getElementById(this.dataset.target);
                let icon = this.querySelector('i');
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    input.type = "password";
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('password_error') || session('password_changed') || $errors->hasAny(['current_password', 'new_password', 'new_password_confirmation']))
            var modal = new bootstrap.Modal(document.getElementById('profileModal'));
            modal.show();

            setTimeout(() => {
                document.querySelector('#current_password')?.focus();
            }, 500);
            @endif
        });
    </script>

</body>

</html>