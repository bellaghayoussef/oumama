<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulaire Complété</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Formulaire Complété</h1>
        <p>Date: {{ $date }}</p>
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
                <th>Formulaire</th>
                <td>{{ $form->name }}</td>
            </tr>
            <tr>
                <th>Tâche</th>
                <td>{{ $form->task->name }}</td>
            </tr>
        </table>
    </div>

    <div class="form-responses">
        <h2>Réponses du Formulaire</h2>
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

    @if($nextTask)
    <div class="next-task">
        <h2>Prochaine Tâche</h2>
        <p>{{ $nextTask->name }}</p>
    </div>
    @endif

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
