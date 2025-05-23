@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Agences</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAgencies }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Agences Actives</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeAgencies }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dossiers Actifs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_dossiers'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Formulaires en Attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_forms'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Forms to Fill -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Formulaires à Remplir</h6>
                </div>
                <div class="card-body">
                    @if($formsToFill->isEmpty())
                        <div class="alert alert-info">
                            Aucun formulaire à remplir pour le moment.
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($formsToFill as $form)
                                <a href="{{ route('admin.dossiers.responses.create', ['dossier' => $form->task->dossiers->first()->id]) }}"
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $form->name }}</h6>
                                        <small class="text-muted">
                                            {{ $form->task->dossiers->first()->procedure->name }}
                                        </small>
                                    </div>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            Agence: {{ $form->task->dossiers->first()->agency->name }}
                                        </small>
                                    </p>
                                    <small class="text-muted">
                                        Tâche: {{ $form->task->name }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pending Forms -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Formulaires en Attente</h6>
                </div>
                <div class="card-body">
                    @if($pendingForms->isEmpty())
                        <div class="alert alert-info">
                            Aucun formulaire en attente de réponse.
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($pendingForms as $response)
                                <a href="{{ route('admin.dossiers.responses.show', ['dossier' => $response->dossier->id, 'response' => $response->id]) }}"
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $response->formuler->name }}</h6>
                                        <small class="text-muted">
                                            {{ $response->dossier->procedure->name }}
                                        </small>
                                    </div>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            Agence: {{ $response->dossier->agency->name }}
                                        </small>
                                    </p>
                                    <small class="text-muted">
                                        Tâche: {{ $response->dossier->task->name }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Dossiers -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Dossiers Récents</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Agence</th>
                            <th>Procédure</th>
                            <th>Tâche</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dossiers as $dossier)
                            <tr>
                                <td>{{ $dossier->reference }}</td>
                                <td>{{ $dossier->agency->name }}</td>
                                <td>{{ $dossier->procedure->name }}</td>
                                <td>{{ $dossier->task->name }}</td>
                                <td>
                                    <span class="badge badge-{{ $dossier->status === 'termine' ? 'success' : ($dossier->status === 'en_cours' ? 'primary' : 'warning') }}">
                                        {{ $dossier->status }}
                                    </span>
                                </td>
                                <td>{{ $dossier->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.dossiers.show', $dossier) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $dossiers->links() }}
            </div>
        </div>
    </div>

    <!-- Recent Agencies -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Agences Récentes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Statut</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAgencies as $agency)
                            <tr>
                                <td>{{ $agency->name }}</td>
                                <td>{{ $agency->email }}</td>
                                <td>{{ $agency->phone }}</td>
                                <td>
                                    <span class="badge badge-{{ $agency->is_active ? 'success' : 'danger' }}">
                                        {{ $agency->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $agency->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.agencies.show', $agency) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-md">
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold">Actions Rapides</h2>
    </div>
    <div class="p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.agencies.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100">
                <i class="fas fa-plus-circle text-blue-500 text-xl mr-3"></i>
                <span class="text-blue-700">Nouvelle Agence</span>
            </a>
            <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100">
                <i class="fas fa-user-plus text-green-500 text-xl mr-3"></i>
                <span class="text-green-700">Nouvel Utilisateur</span>
            </a>
            <a href="{{ route('admin.agencies.index') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100">
                <i class="fas fa-cog text-purple-500 text-xl mr-3"></i>
                <span class="text-purple-700">Gérer les Agences</span>
            </a>
        </div>
    </div>
</div>
@endsection
