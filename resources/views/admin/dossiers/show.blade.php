@extends('admin.layouts.app')

@section('title', 'Détails du Dossier')
@section('header', 'Détails du Dossier')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informations de base -->
        <div class="col-span-1">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations du Dossier</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Procédure</p>
                    <p class="mt-1 text-gray-900">{{ $dossier->procedure->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Agence</p>
                    <p class="mt-1 text-gray-900">{{ $dossier->agency->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Utilisateur</p>
                    <p class="mt-1 text-gray-900">{{ $dossier->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Tâche</p>
                    <p class="mt-1 text-gray-900">{{ $dossier->task->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Statut</p>
                    <p class="mt-1">
                        <span class="px-2 py-1 text-sm rounded-full
                            @if($dossier->status == 'en_attente') bg-yellow-100 text-yellow-800
                            @elseif($dossier->status == 'en_cours') bg-blue-100 text-blue-800
                            @elseif($dossier->status == 'termine') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $dossier->status)) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Dates et métadonnées -->
        <div class="col-span-1">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Métadonnées</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Date de création</p>
                    <p class="mt-1 text-gray-900">{{ $dossier->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Dernière mise à jour</p>
                    <p class="mt-1 text-gray-900">{{ $dossier->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 flex justify-end space-x-3">
        <a href="{{ route('admin.dossiers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
            Retour
        </a>
        <a href="{{ route('admin.dossiers.edit', $dossier) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
            Modifier
        </a>
    </div>
</div>
@endsection 