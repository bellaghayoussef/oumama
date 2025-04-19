@extends('admin.layouts.app')

@section('title', 'Détails de la Variable')
@section('header', 'Détails de la Variable')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Informations de la Variable</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.variables.edit', $variable) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('admin.variables.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">ID</h3>
                <p class="mt-1 text-gray-900">{{ $variable->id }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Nom</h3>
                <p class="mt-1 text-gray-900">{{ $variable->name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Type</h3>
                <p class="mt-1 text-gray-900">{{ ucfirst($variable->type) }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Formulaire</h3>
                <p class="mt-1 text-gray-900">{{ $variable->formuler->name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Tâche</h3>
                <p class="mt-1 text-gray-900">{{ $variable->formuler->task->name }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Étape</h3>
                <p class="mt-1 text-gray-900">{{ $variable->formuler->task->etap->name }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500">Procédure</h3>
            <p class="mt-1 text-gray-900">{{ $variable->formuler->task->etap->procedure->name }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Créé le</h3>
                <p class="mt-1 text-gray-900">{{ $variable->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Dernière modification</h3>
                <p class="mt-1 text-gray-900">{{ $variable->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 