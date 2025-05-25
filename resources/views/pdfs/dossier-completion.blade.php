<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dossier Terminé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .details {
            margin-bottom: 20px;
        }
        .signature-section {
            margin-top: 50px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        .signature-box {
            width: 45%;
            float: left;
            margin: 10px;
        }
        .clear {
            clear: both;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .signature-image {
            max-width: 200px;
            max-height: 100px;
        }
        .completion-stamp {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 48px;
            color: rgba(0, 128, 0, 0.2);
            border: 5px solid rgba(0, 128, 0, 0.2);
            padding: 20px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dossier Terminé</h1>
        <p>Date: {{ $date }}</p>
        <div class="completion-stamp">Terminé</div>
    </div>

    <div class="details">
        <h2>Détails du Dossier</h2>
        <table>
            <tr>
                <th>Procédure</th>
                <td>{{ $dossier->procedure->name }}</td>
            </tr>
            <tr>
                <th>Agence</th>
                <td>{{ $dossier->agency->name }}</td>
            </tr>
            <tr>
                <th>Client</th>
                <td>{{ $dossier->user->name }}</td>
            </tr>
            <tr>
                <th>Dernier Formulaire</th>
                <td>{{ $form->name }}</td>
            </tr>
            <tr>
                <th>Dernière Tâche</th>
                <td>{{ $form->task->name }}</td>
            </tr>
            <tr>
                <th>Statut</th>
                <td>Terminé</td>
            </tr>
        </table>
    </div>

    <div class="form-responses">
        <h2>Dernières Réponses</h2>
        <table>
            <tr>
                <th>Champ</th>
                <th>Valeur</th>
            </tr>
            @foreach($form->variables as $variable)
            <tr>
                <td>{{ $variable->name }}</td>
                <td>
                    @if($variable->type === 'file')
                        <a href="{{ asset($form->answers[$variable->id] ?? '') }}">Voir le fichier</a>
                    @else
                        {{ $form->answers[$variable->id] ?? 'Non renseigné' }}
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <h3>Signature du Client</h3>
            @if($signature)
                <img src="{{ $signature }}" class="signature-image" alt="Signature du client">
            @else
                <p>Signature non disponible</p>
            @endif
            <p>{{ $dossier->user->name }}</p>
        </div>

        <div class="signature-box">
            <h3>Signature de l'Agence</h3>
            @if($agency_signature)
                <img src="{{ $agency_signature }}" class="signature-image" alt="Signature de l'agence">
            @else
                <p>Signature non disponible</p>
            @endif
            <p>{{ $dossier->agency->name }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
