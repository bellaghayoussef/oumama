@extends('admin.layouts.app')

@section('title', 'Détails de la Réponse')
@section('header', 'Détails de la Réponse')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Informations de la Réponse</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.repences.edit', $repence) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('admin.repences.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">ID</h3>
                <p class="mt-1 text-gray-900">{{ $repence->id }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Variable</h3>
                <p class="mt-1 text-gray-900">{{ $repence->variable->name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Type de Variable</h3>
                <p class="mt-1 text-gray-900">{{ ucfirst($repence->variable->type) }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Formulaire</h3>
                <p class="mt-1 text-gray-900">{{ $repence->variable->formuler->name }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500">Valeur</h3>
            <p class="mt-1 text-gray-900">{{ $repence->value }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500">Répondant</h3>
            <p class="mt-1 text-gray-900">
                @if($repence->user_id)
                    Utilisateur: {{ $repence->user->name }}
                @elseif($repence->agency_id)
                    Agence: {{ $repence->agency->name }}
                @elseif($repence->admin_id)
                    Admin: {{ $repence->admin->name }}
                @else
                    Non spécifié
                @endif
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Créé le</h3>
                <p class="mt-1 text-gray-900">{{ $repence->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Dernière modification</h3>
                <p class="mt-1 text-gray-900">{{ $repence->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 