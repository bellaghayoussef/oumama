@extends('admin.layouts.app')

@section('title', 'Détails de la Procédure')
@section('header', 'Détails de la Procédure')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Informations de la Procédure</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.procedures.edit', $procedure) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('admin.procedures.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">ID</h3>
                <p class="mt-1 text-gray-900">{{ $procedure->id }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Nom</h3>
                <p class="mt-1 text-gray-900">{{ $procedure->name }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500">Description</h3>
            <p class="mt-1 text-gray-900">{{ $procedure->description }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Créé le</h3>
                <p class="mt-1 text-gray-900">{{ $procedure->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Dernière modification</h3>
                <p class="mt-1 text-gray-900">{{ $procedure->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 