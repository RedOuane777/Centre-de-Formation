<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Attestation de Scolarité</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #111;
            background: #fff;
        }

        .page {
            width: 180mm;
            margin: 10mm auto;
            border: 1px solid #000;
            padding: 12mm 14mm 10mm 14mm;
        }

        .hdr {
            text-align: center;
            border-bottom: 1.5px solid #000;
            padding-bottom: 5mm;
            margin-bottom: 6mm;
        }
        .hdr-name  { font-size: 13pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .hdr-sub   { font-size: 9pt; color: #555; margin-top: 1.5mm; }
        .hdr-title { font-size: 12pt; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; margin-top: 4mm; }

        .body-wrap { text-align: center; margin: 5mm 0; line-height: 1.9; }
        .intro     { font-size: 10pt; }
        .sname     { font-size: 15pt; font-weight: bold; text-decoration: underline; margin: 3mm 0; }
        .stmt      { font-size: 10pt; }

        .det-wrap {
            margin: 5mm auto;
            width: 130mm;
            border-top: 1px solid #aaa;
            border-bottom: 1px solid #aaa;
            padding: 3mm 0;
        }
        .det-table     { width: 100%; border-collapse: collapse; }
        .det-table td  { padding: 2mm 3mm; font-size: 10pt; vertical-align: top; }
        .det-label     { font-weight: bold; width: 45mm; }

        .purpose {
            text-align: center;
            font-size: 9.5pt;
            font-style: italic;
            color: #333;
            margin: 5mm 5mm;
            line-height: 1.6;
        }

        .bot-table     { width: 100%; border-collapse: collapse; margin-top: 8mm; }
        .bot-table td  { width: 50%; vertical-align: middle; text-align: center; padding: 0 3mm; }
        .bt-date       { font-size: 9.5pt; margin-bottom: 8mm; }
        .bt-dir        { font-size: 10pt; font-weight: bold; }
        .bt-sig        { margin: 3mm auto 0; width: 38mm; border-bottom: 1px solid #000; }

        .doc-ftr {
            margin-top: 6mm;
            border-top: 1px solid #ccc;
            padding-top: 2mm;
            text-align: center;
            font-size: 7pt;
            color: #999;
        }
    </style>
</head>
<body>

<div class="page">

    <div class="hdr">
        <div class="hdr-name">Centre de Formation Professionnelle</div>
        <div class="hdr-sub">Formation Professionnelle &amp; Continue</div>
        <div class="hdr-title">Attestation de Scolarité</div>
    </div>

    <div class="body-wrap">
        <p class="intro">Nous soussignés, certifions que l'étudiant(e) :</p>
        <p class="sname">{{ ucwords(strtolower($etudiant->user->nom)) }} {{ ucwords(strtolower($etudiant->user->prenom)) }}</p>
        <p class="stmt">est régulièrement inscrit(e) dans notre établissement pour l'année en cours.</p>
    </div>

    <div class="det-wrap">
        <table class="det-table">
            <tr>
                <td class="det-label">Filière :</td>
                <td>{{ $etudiant->filiere->libelle }}</td>
            </tr>
            <tr>
                <td class="det-label">Groupe :</td>
                <td>{{ $etudiant->groupe->libelle }}</td>
            </tr>
            <tr>
                <td class="det-label">Date de délivrance :</td>
                <td>{{ date('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <p class="purpose">
        Cette attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.
    </p>

    <table class="bot-table">
        <tr>
            <td>
                <svg width="75" height="75" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="46" fill="none" stroke="#111" stroke-width="2.5"/>
                    <circle cx="50" cy="50" r="37" fill="none" stroke="#111" stroke-width="1" stroke-dasharray="3,3"/>
                    <text x="50" y="47" text-anchor="middle" font-family="DejaVu Sans,sans-serif" font-size="10" font-weight="bold" fill="#111">CACHET</text>
                    <text x="50" y="61" text-anchor="middle" font-family="DejaVu Sans,sans-serif" font-size="10" font-weight="bold" fill="#111">OFFICIEL</text>
                </svg>
            </td>
            <td>
                <p class="bt-date">Fait le {{ date('d/m/Y') }}</p>
                <p class="bt-dir">Le Directeur</p>
                <div class="bt-sig"></div>
            </td>
        </tr>
    </table>

    <div class="doc-ftr">
        Généré le {{ date('d/m/Y') }}
    </div>

</div>
</body>
</html>