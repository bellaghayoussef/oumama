@component('mail::message')
# Dossier Terminé

Bonjour,

Le dossier "{{ $dossier->procedure->name }}" a été complété avec succès.

**Détails du dossier:**
- Agence: {{ $agency->name }}
- Client: {{ $user->name }}
- Procédure: {{ $dossier->procedure->name }}
- Dernière tâche: {{ $form->task->name }}

@component('mail::button', ['url' => route('admin.dossiers.show', $dossier)])
Voir le Dossier
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
