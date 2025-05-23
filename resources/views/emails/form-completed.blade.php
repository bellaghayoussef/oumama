@component('mail::message')
# Formulaire Complété

Bonjour,

Le formulaire "{{ $form->name }}" a été complété pour le dossier "{{ $dossier->procedure->name }}".

**Détails du dossier:**
- Agence: {{ $agency->name }}
- Client: {{ $user->name }}
- Procédure: {{ $dossier->procedure->name }}
- Tâche actuelle: {{ $form->task->name }}

@if($nextTask)
**Prochaine étape:**
La prochaine tâche "{{ $nextTask->name }}" est maintenant disponible.

@component('mail::button', ['url' => route('admin.dossiers.show', $dossier)])
Voir le Dossier
@endcomponent
@endif

Merci,<br>
{{ config('app.name') }}
@endcomponent
