<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Relevé de Notes</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #111;
            background: #fff;
            line-height: 1.4;
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

        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 6mm; }
        .info-table td { font-size: 10pt; padding: 2mm 3mm; }
        .info-label { font-weight: bold; width: 35mm; }

        .notes-table { width: 100%; border-collapse: collapse; margin-bottom: 5mm; }
        .notes-table th {
            background-color: #e9ecef;
            border: 1px solid #000;
            padding: 2.5mm 3mm;
            font-size: 10pt;
            text-align: center;
        }
        .notes-table td {
            border: 1px solid #000;
            padding: 2.5mm 3mm;
            font-size: 10pt;
            text-align: center;
            background-color: #fff;
        }
        
        .notes-table tr:nth-child(even) td { background-color: #fafdff; }

        .moyenne {
            text-align: right;
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 6mm;
            padding-top: 2.5mm;
            border-top: 1px solid #000;
        }

        .bot-table  { width: 100%; border-collapse: collapse; margin-top: 4mm; }
        .bot-table td { width: 50%; vertical-align: middle; text-align: center; padding: 0 3mm; }
        .bt-date    { font-size: 9.5pt; margin-bottom: 8mm; }
        .bt-dir     { font-size: 10pt; font-weight: bold; }
        .bt-sig     { margin: 3mm auto 0; width: 38mm; border-bottom: 1px solid #000; }

        .doc-ftr {
            margin-top: 6mm;
            border-top: 1px solid #ccc;
            padding-top: 2mm;
            text-align: center;
            font-size: 7.5pt;
            color: #999;
        }
    </style>
</head>
<body>

<div class="page">

    <div class="hdr">
        <div class="hdr-name">Centre de Formation</div>
        <div class="hdr-sub">Formation Professionnelle</div>
        <div class="hdr-title">Relevé de Notes</div>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Étudiant(e) :</td>
            <td>{{ ucwords(strtolower($etudiant->user->nom)) }} {{ ucwords(strtolower($etudiant->user->prenom)) }}</td>
            <td class="info-label">Filière :</td>
            <td>{{ $etudiant->filiere->libelle }}</td>
        </tr>
        <tr>
            <td class="info-label">Groupe :</td>
            <td colspan="3">{{ $etudiant->groupe->libelle }}</td>
        </tr>
    </table>

    <table class="notes-table">
        <thead>
            <tr>
                <th style="text-align: left; padding-left: 4mm; width: 35%;">Module</th>
                
                @for($i = 1; $i <= $maxNotesCount; $i++)
                    <th style="width: 15%;">Note {{ $i }}</th>
                @endfor
                
                <th style="width: 20%;">Moyenne Module</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modulesData as $data)
            <tr>
                <td style="text-align: left; padding-left: 4mm; font-weight: bold;">{{ $data['titre'] }}</td>
                
                @for($i = 0; $i < $maxNotesCount; $i++)
                    <td>
                        @if(isset($data['notes'][$i]))
                            {{ number_format($data['notes'][$i], 2) }}
                        @else
                            -
                        @endif
                    </td>
                @endfor
                
                <td style="font-weight: bold;">
                    {{ $data['moyenne'] !== null ? number_format($data['moyenne'], 2) : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="moyenne">
        Moyenne Générale : {{ number_format($moyenneGenerale, 2) }} / 20
    </div>

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