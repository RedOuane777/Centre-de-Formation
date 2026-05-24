@extends('layouts.public')
@section('content')
<style>
    :root {
        --primary: #1D4ED8;
        --primary-dark: #0B2A5B;
        --secondary: #3B82F6;
        --text-dark: #111827;
        --text-muted: #6B7280;
        --bg-light: #F3F4F6;
    }

    .hero {
        background: linear-gradient(135deg, #0B2A5B 0%, #1844ba 100%);
        min-height: calc(100vh - 62px);
        display: flex;
        align-items: center;

        padding: 40px 20px;
        color: white;
        margin-bottom: 0;
    }

    .hero .col-lg-6 {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    .hero-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        margin-bottom: 20px;
        letter-spacing: 0.5px;
    }

    .hero h1 {
        font-size: 2.4rem;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 16px;
    }

    .hero p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 30px;
    }

    .btn-white {
        background: white;
        color: var(--primary);
        padding: 11px 26px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
        font-size: 0.95rem;
    }

    .btn-white:hover {
        background: #e0e7ff;
        color: var(--primary);
    }

    .btn-ghost {
        background: transparent;
        color: white;
        padding: 11px 26px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        border: 2px solid rgba(255, 255, 255, 0.5);
        transition: all 0.2s;
        font-size: 0.95rem;
    }

    .btn-ghost:hover {
        border-color: white;
        background: rgba(255, 255, 255, 0.08);
        color: white;
    }

    .hero-visual {
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 16px;
        padding: 28px;
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        color: #93C5FD;
        line-height: 2.1;
    }

    .hero-visual .line-green {
        color: #6EE7B7;
    }

    .hero-visual .line-yellow {
        color: #FCD34D;
    }

    .hero-visual .line-white {
        color: white;
    }

    .section {
        padding: 65px 20px;
    }

    .section-title {
        font-size: 1.65rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .section-sub {
        color: var(--text-muted);
        margin-bottom: 40px;
        font-size: 0.95rem;
    }

    .filieres-section {
        background: var(--bg-light);
        margin-top: 0;
    }

    .filiere-card {
        background: white;
        border-radius: 12px;
        padding: 28px 22px;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.07);
        border-top: 4px solid var(--primary);
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .filiere-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.09);
    }

    .filiere-tag {
        display: inline-block;
        background: #EFF6FF;
        color: var(--primary);
        font-size: 0.78rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        margin-bottom: 12px;
    }

    .filiere-card .filiere-icon {
        font-size: 1.8rem;
        color: var(--primary);
        margin-bottom: 14px;
        display: block;
    }

    .filiere-card h5 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
        font-size: 1rem;
    }

    .filiere-card p {
        color: var(--text-muted);
        font-size: 0.88rem;
        margin: 0;
        line-height: 1.6;
    }

    .steps-section {
        background: white;
    }

    .step-wrap {
        position: relative;
        padding-left: 58px;
        margin-bottom: 32px;
    }

    .step-wrap:last-child {
        margin-bottom: 0;
    }

    .step-num {
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .step-wrap h6 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
        font-size: 0.98rem;
        padding-top: 8px;
    }

    .step-wrap p {
        color: var(--text-muted);
        font-size: 0.88rem;
        margin: 0;
        line-height: 1.6;
    }

    .steps-visual {
        background: var(--bg-light);
        border-radius: 16px;
        padding: 35px 30px;
        text-align: center;
    }

    .steps-visual i {
        font-size: 3.5rem;
        color: var(--primary);
        margin-bottom: 16px;
        display: block;
    }

    .steps-visual h5 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .steps-visual p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.6;
    }

    .espace-section {
        background: var(--bg-light);
    }

    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 22px;
    }

    .feature-icon {
        width: 44px;
        height: 44px;
        background: #EFF6FF;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--primary);
        flex-shrink: 0;
    }

    .feature-item h6 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 3px;
        font-size: 0.95rem;
    }

    .feature-item p {
        color: var(--text-muted);
        font-size: 0.87rem;
        margin: 0;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 1.7rem;
        }

        .hero p {
            font-size: 0.95rem;
        }

        .hero-visual {
            font-size: 0.78rem;
            padding: 20px;
            margin-top: 30px;
        }

        .section-title {
            font-size: 1.4rem;
        }

        .section {
            padding: 50px 15px;
        }

        .steps-visual {
            margin-top: 30px;
        }
    }

    @media (max-width: 480px) {
        .hero {
            padding: 55px 15px;
        }

        .hero h1 {
            font-size: 1.5rem;
        }

        .btn-white,
        .btn-ghost {
            width: 100%;
            text-align: center;
        }

        .d-flex.gap-3 {
            flex-direction: column;
        }
    }
</style>

<section class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="hero-badge">
                    <i class="bi bi-mortarboard-fill me-1"></i> Inscriptions ouvertes
                </span>
                <h1>Formez-vous aux métiers du numérique</h1>
                <p>
                    Notre centre vous accueille en présentiel pour des formations en développement,
                    réseaux et systèmes. Inscrivez-vous en ligne et commencez votre parcours professionnel.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register.create') }}" class="btn-white">
                        <i class="bi bi-pencil-square me-1"></i> S'inscrire en ligne
                    </a>
                    <a href="{{ route('login') }}" class="btn-ghost">
                        <i class="bi bi-person-circle me-1"></i> Mon espace
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-visual">
                    <div class="line-green">// Centre de Formation</div>
                    <div class="line-yellow">function <span class="line-white">inscription</span>() {</div>
                    <div>&nbsp;&nbsp;choisir<span class="line-green">(filiere)</span>;</div>
                    <div>&nbsp;&nbsp;soumettre<span class="line-green">(dossier)</span>;</div>
                    <div>&nbsp;&nbsp;attendre<span class="line-yellow">(validation)</span>;</div>
                    <div>&nbsp;&nbsp;<span class="line-green">return</span> <span class="line-white">"Bienvenue !"</span>;</div>
                    <div class="line-yellow">}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section filieres-section">
    <div class="container">
        <h2 class="section-title">Nos filières de formation</h2>
        <p class="section-sub">Des formations pratiques adaptées au marché de l'emploi</p>
        <div class="row g-4">
            <div class="col-md-4 col-sm-6">
                <div class="filiere-card">
                    <i class="bi bi-code-slash filiere-icon"></i>
                    <span class="filiere-tag">Développement</span>
                    <h5>Développement Web & Mobile</h5>
                    <p>HTML, CSS, JavaScript, PHP, Laravel, bases de données et conception d'applications.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="filiere-card">
                    <i class="bi bi-hdd-network filiere-icon"></i>
                    <span class="filiere-tag">Infrastructure</span>
                    <h5>Réseaux & Systèmes</h5>
                    <p>Administration des réseaux, systèmes Linux/Windows, sécurité informatique.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="filiere-card">
                    <i class="bi bi-database filiere-icon"></i>
                    <span class="filiere-tag">Data</span>
                    <h5>Bases de Données</h5>
                    <p>Conception, administration et analyse de bases de données relationnelles.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section steps-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="section-title">Comment s'inscrire ?</h2>
                <p class="section-sub">Un processus simple en 4 étapes</p>
                <div class="step-wrap">
                    <div class="step-num">1</div>
                    <h6>Créer votre compte</h6>
                    <p>Remplissez le formulaire en ligne avec vos informations personnelles.</p>
                </div>
                <div class="step-wrap">
                    <div class="step-num">2</div>
                    <h6>Choisir votre filière</h6>
                    <p>Sélectionnez la filière et le groupe qui correspond à votre projet.</p>
                </div>
                <div class="step-wrap">
                    <div class="step-num">3</div>
                    <h6>Validation par l'administration</h6>
                    <p>Votre dossier est examiné. Vous serez notifié de la décision.</p>
                </div>
                <div class="step-wrap">
                    <div class="step-num">4</div>
                    <h6>Accéder à votre espace</h6>
                    <p>Une fois accepté, consultez vos modules, examens et emploi du temps.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="steps-visual">
                    <i class="bi bi-building"></i>
                    <h5>Formation en présentiel</h5>
                    <p>Tous nos cours se déroulent dans nos locaux avec des formateurs qualifiés. La plateforme vous permet de suivre votre parcours et rester informé.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section espace-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <h2 class="section-title">Votre espace étudiant</h2>
                <p class="section-sub">Après votre acceptation, accédez à tout votre parcours en un seul endroit.</p>
                <a href="{{ route('register.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Commencer l'inscription
                </a>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-book"></i></div>
                            <div>
                                <h6>Modules</h6>
                                <p>Consultez les cours et contenus de votre filière.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-clipboard2-check"></i></div>
                            <div>
                                <h6>Examens</h6>
                                <p>Suivez vos examens programmés et vos résultats.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-calendar3"></i></div>
                            <div>
                                <h6>Emploi du temps</h6>
                                <p>Visualisez vos séances et horaires de cours.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-bar-chart-line"></i></div>
                            <div>
                                <h6>Notes & Résultats</h6>
                                <p>Suivez votre progression et vos performances.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection