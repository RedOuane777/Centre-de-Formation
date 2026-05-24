<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Accès refusé</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9fafb;
            color: #111827;
        }

        .container {
            max-width: 700px;
            margin: 120px auto;
            padding: 40px;
            background: #ffffff;
            border-left: 5px solid #EF4444;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 15px;
            color: #111827;
        }

        p {
            font-size: 16px;
            line-height: 1.7;
            color: #6B7280;
            margin-bottom: 25px;
        }

        a {
            display: inline-block;
            padding: 10px 18px;
            background: #1D4ED8;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.2s;
        }

        .image {
            flex: 1;
            text-align: center;
        }

        .image img {
            max-width: 250px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="text">

            <h1>Non, monsieur</h1>

            <p>
                Non, on ne fait pas ça ici.<br>
                Veuillez revenir à votre espace.
            </p>

            <a href="{{ route('login') }}">Retour à la page de connexion</a>

        </div>

        <div class="image">
            <img src="{{ asset('images/forbidden.jpeg') }}" alt="Access Denied">
        </div>

    </div>

</body>

</html>