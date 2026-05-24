<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Centre de Formation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}">

    <style>

        :root {
            --primary-color: #1D4ED8;
            --secondary-color: #3B82F6;
            --bg-light: #F3F4F6;
            --text-dark: #111827;
            --text-muted: #6B7280;
        }

        .navbar {
            background: linear-gradient(90deg, #0B2A5B, #1844ba);
            padding: 6px 30px;
            margin-bottom: 0 !important;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            margin-left: 15px;
            position: relative;
            padding-bottom: 3px;
        }

        .navbar .nav-links a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 2px;
            background-color: #ffffff;
            transition: width 0.25s ease;
        }

        .navbar .nav-links a:hover::after {
            width: 100%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a href="{{ route('welcome') }}" class="navbar-brand"><img src="{{ asset('images/centreformation.png') }}" style="width: 180px; height: 50px"></a>

            <div class="d-flex align-items-center">

                <div class="nav-links">
                    <a href="{{ route('welcome') }}" class="me-3">Accueil</a>
                    <a href="{{ route('login') }}" class="me-3">Login</a>
                    <a href="{{ route('register.create') }}">Inscription</a>
                </div>
            </div>
        </div>
    </nav>

    <div>
        @yield('content')
    </div>

    <footer style="background: linear-gradient(90deg, #0B2A5B, #1844ba); color: white; padding: 30px;">
        <div class="container-fluid">
            <div class="row g-4 justify-content-between">
                <div class="col-md-4">
                    <h6 style="font-weight: 700; margin-bottom: 10px;">Centre de Formation</h6>
                    <p style="color: rgba(255,255,255,0.65); font-size: 0.85rem; margin: 0;">
                        Formation professionnelle en présentiel dédiée aux métiers du numérique.
                    </p>
                </div>
                <div class="col-md-4">
                    <h6 style="font-weight: 700; margin-bottom: 10px;">Contact</h6>
                    <p style="color: rgba(255,255,255,0.65); font-size: 0.85rem; margin-bottom: 6px;">
                        <i class="bi bi-geo-alt-fill me-2"></i> 123 Rue principale, Ville
                    </p>
                    <p style="color: rgba(255,255,255,0.65); font-size: 0.85rem; margin-bottom: 6px;">
                        <i class="bi bi-telephone-fill me-2"></i> +212 623452624
                    </p>
                    <p style="color: rgba(255,255,255,0.65); font-size: 0.85rem; margin: 0;">
                        <i class="bi bi-envelope-fill me-2"></i> centreFormation@gmail.com
                    </p>
                </div>
                <div class="col-md-3">
                    <h6 style="font-weight: 700; margin-bottom: 10px;">Suivez-nous</h6>
                    <div class="d-flex gap-3">
                        <a href="#" style="color: rgba(255,255,255,0.65); font-size: 1.4rem; text-decoration: none;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" style="color: rgba(255,255,255,0.65); font-size: 1.4rem; text-decoration: none;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" style="color: rgba(255,255,255,0.65); font-size: 1.4rem; text-decoration: none;">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" style="color: rgba(255,255,255,0.65); font-size: 1.6rem; text-decoration: none;">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.5); margin: 20px 0 15px;">
            <div class="text-center" style="color: rgba(255,255,255,0.5); font-size: 0.8rem;">
                © {{ date('Y') }} Centre de Formation. Tous droits réservés.
            </div>
        </div>
    </footer>

</body>
</html>
</body>

</html>