@extends('admin.layouts.app')

@section('title', 'Détails de la Réponse')
@section('header', 'Détails de la Réponse')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ $response->formuler->name }}</h6>
            <div>
                @if($response->status === 'admin')
                    <a href="{{ route('admin.dossiers.responses.edit', ['dossier' => $dossier->id, 'response' => $response->id]) }}"
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                @endif
                <a href="{{ route('admin.dossiers.show', $dossier) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Retour au Dossier
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <span class="badge badge-{{ $response->status === 'termine' ? 'success' : ($response->status === 'admin' ? 'warning' : 'info') }}">
                    {{ $response->status }}
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50%">Champ</th>
                            <th style="width: 50%">Valeur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $answers = $response->answers;
                            $variables = $response->formuler->variables;
                        @endphp

                        @forelse($variables as $variable)
                            <tr>
                                <td>
                                    {{ $variable->name }}
                                    @if($variable->required)
                                        <span class="text-danger">*</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($answers[$variable->id]))
                                        @if($variable->type === 'file')
                                            <a href="{{ Storage::url($answers[$variable->id]) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-download"></i> Télécharger le fichier
                                            </a>
                                        @else
                                            {{ $answers[$variable->id] }}
                                        @endif
                                    @else
                                        <span class="text-muted">Non renseigné</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Aucun champ dans ce formulaire.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
