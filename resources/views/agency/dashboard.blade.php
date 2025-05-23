@extends('agency.layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <!-- Statistics Cards -->
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Dossiers</h5>
                    <h2 class="card-text">{{ $stats['total_dossiers'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Formulaires en attente</h5>
                    <h2 class="card-text">{{ $stats['pending_forms'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Formulaires complétés</h5>
                    <h2 class="card-text">{{ $stats['completed_forms'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Dossiers actifs</h5>
                    <h2 class="card-text">{{ $stats['active_dossiers'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Forms to Fill Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Formulaires à remplir</h5>
                    <a href="{{ route('agency.dossiers.index') }}" class="btn btn-sm btn-primary">Voir tous</a>
                </div>
                <div class="card-body">
                    @if($formsToFill->isNotEmpty())
                        <div class="list-group">
                            @foreach($formsToFill as $form)
                                @php
                                    $dossier = $form->task->dossiers->first();
                                @endphp
                                @if($dossier)
                                    <a href="{{ route('agency.dossiers.responses.create', ['dossier' => $dossier->id, 'form' => $form->id]) }}"
                                       class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $form->name }}</h6>
                                            <button class="btn btn-sm btn-success">Remplir</button>
                                        </div>
                                        <p class="mb-1">
                                            <small class="text-muted">
                                                Dossier #{{ $dossier->id }}<br>
                                                Procédure: {{ $dossier->procedure->name }}<br>
                                                @if($dossier->task)
                                                    Tâche actuelle: {{ $dossier->task->name }}
                                                @endif
                                            </small>
                                        </p>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Aucun formulaire à remplir pour le moment.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pending Forms Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Formulaires en attente</h5>
                    <a href="{{ route('agency.dossiers.index') }}" class="btn btn-sm btn-primary">Voir tous</a>
                </div>
                <div class="card-body">
                    @if($pendingForms->isNotEmpty())
                        <div class="list-group">
                            @foreach($pendingForms as $response)
                                <a href="{{ route('agency.dossiers.responses.edit', ['dossier' => $response->dossier->id, 'response' => $response->id]) }}"
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $response->formuler->name }}</h6>
                                        <small>Dossier #{{ $response->dossier->id }}</small>
                                    </div>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            Procédure: {{ $response->dossier->procedure->name }}<br>
                                            Tâche: {{ $response->dossier->task->name }}
                                        </small>
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Aucun formulaire en attente de réponse.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Dossiers Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dossiers récents</h5>
                    <a href="{{ route('agency.dossiers.index') }}" class="btn btn-sm btn-primary">Voir tous</a>
                </div>
                <div class="card-body">
                    @if($dossiers->isNotEmpty())
                        <div class="list-group">
                            @foreach($dossiers as $dossier)
                                <a href="{{ route('agency.dossiers.show', $dossier) }}"
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Dossier #{{ $dossier->id }}</h6>
                                        <small>
                                            <span class="badge bg-{{ $dossier->status === 'termine' ? 'success' : ($dossier->status === 'en_cours' ? 'primary' : 'warning') }}">
                                                {{ $dossier->status }}
                                            </span>
                                        </small>
                                    </div>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            Procédure: {{ $dossier->procedure->name }}<br>
                                            @if($dossier->task)
                                                Tâche actuelle: {{ $dossier->task->name }}
                                            @endif
                                        </small>
                                    </p>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            {{ $dossiers->links() }}
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Aucun dossier trouvé.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
