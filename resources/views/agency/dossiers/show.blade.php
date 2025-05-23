@extends('agency.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Dossier #{{ $dossier->id }}</h4>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informations du dossier</h5>
                            <p><strong>Procédure:</strong> {{ $dossier->procedure->name }}</p>
                            <p><strong>Statut:</strong> {{ $dossier->status }}</p>
                            <p><strong>Utilisateur:</strong> {{ $dossier->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Étape actuelle</h5>
                            @if($currentTask)
                                <p><strong>Tâche:</strong> {{ $currentTask->name }}</p>
                                @if($currentForm)
                                    <p><strong>Formulaire:</strong> {{ $currentForm->name }}</p>
                                    <p><strong>Statut du formulaire:</strong> {{ $currentResponse ? $currentResponse->status : 'Non commencé' }}</p>
                                @endif
                            @else
                                <p>Aucune tâche en cours</p>
                            @endif
                        </div>
                    </div>

                    @if($currentForm)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5>Formulaire: {{ $currentForm->name }}</h5>
                            </div>
                            <div class="card-body">
                                @if($canFillForm)
                                    <form action="{{ route('agency.dossiers.update-response', ['dossier' => $dossier->id, 'response' => $currentResponse->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        {{-- Add your form fields here based on your form structure --}}
                                        {{-- Example: --}}
                                        {{-- @foreach($currentForm->questions as $question) --}}
                                        {{--     <div class="form-group"> --}}
                                        {{--         <label>{{ $question->text }}</label> --}}
                                        {{--         <input type="text" name="answers[{{ $question->id }}]" class="form-control"> --}}
                                        {{--     </div> --}}
                                        {{-- @endforeach --}}

                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary">Soumettre les réponses</button>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        @if($currentResponse)
                                            Ce formulaire est actuellement en statut "{{ $currentResponse->status }}".
                                            @if($currentResponse->status === 'en_cours')
                                                Il n'est pas encore prêt pour être rempli par l'agence.
                                            @elseif($currentResponse->status === 'termine')
                                                Ce formulaire a déjà été complété.
                                            @endif
                                        @else
                                            Aucune réponse n'a été créée pour ce formulaire.
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Aucun formulaire n'est disponible pour l'étape actuelle.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
