@extends('agency.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Formulaire: {{ $response->formuler->name }}</h4>
                    <div>
                        @if($response->status === 'agency')
                            <a href="{{ route('agency.dossiers.responses.edit', ['dossier' => $dossier->id, 'response' => $response->id]) }}"
                               class="btn btn-primary">Modifier</a>
                        @endif
                        <a href="{{ route('agency.dossiers.show', $dossier) }}" class="btn btn-secondary">Retour au dossier</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Statut:
                            <span class="badge bg-{{ $response->status === 'termine' ? 'success' : ($response->status === 'agency' ? 'warning' : 'info') }}">
                                {{ $response->status }}
                            </span>
                        </h5>
                    </div>

                    @if($response->answers)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Question</th>
                                        <th>Réponse</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($response->formuler->questions as $question)
                                        <tr>
                                            <td>{{ $question->text }}</td>
                                            <td>{{ $response->answers[$question->id] ?? 'Non répondu' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Aucune réponse n'a été enregistrée pour ce formulaire.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
