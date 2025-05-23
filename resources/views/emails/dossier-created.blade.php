@component('mail::message')
# Nouveau Dossier Créé

Un nouveau dossier a été créé dans le système.

**Détails du dossier:**
- ID: {{ $dossier->id }}
- Procédure: {{ $dossier->procedure->name }}
- Agence: {{ $dossier->agency->name }}
- Utilisateur: {{ $dossier->user->name }}
- Statut: {{ $dossier->status }}

@component('mail::button', ['url' => route('admin.dossiers.show', $dossier)])
Voir le Dossier
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
