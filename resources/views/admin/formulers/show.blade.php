@extends('admin.layouts.app')

@section('title', 'Détails du Formulaire')
@section('header', 'Détails du Formulaire')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">{{ $formuler->name }}</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.formulers.edit', $formuler) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Modifier
            </a>
            <form action="{{ route('admin.formulers.destroy', $formuler) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce formulaire ?')">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-medium text-gray-700 mb-4">Informations du Formulaire</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nom</p>
                    <p class="mt-1 text-gray-900">{{ $formuler->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Tâche</p>
                    <p class="mt-1 text-gray-900">{{ $formuler->task->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Étape</p>
                    <p class="mt-1 text-gray-900">{{ $formuler->task->etap->name }}</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-medium text-gray-700 mb-4">Variables</h3>
            @if($formuler->variables->count() > 0)
                <div class="space-y-4">
                    @foreach($formuler->variables as $variable)
                        <div class="border-b border-gray-200 pb-4">
                            <p class="text-sm font-medium text-gray-500">Nom</p>
                            <p class="mt-1 text-gray-900">{{ $variable->name }}</p>
                            <p class="text-sm font-medium text-gray-500 mt-2">Type</p>
                            <p class="mt-1 text-gray-900">{{ $variable->type }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Aucune variable n'est associée à ce formulaire.</p>
            @endif
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-700 mb-4">Questions</h3>
        @if($formuler->questions->count() > 0)
            <div class="space-y-4">
                @foreach($formuler->questions as $question)
                    <div class="border-b border-gray-200 pb-4">
                        <p class="text-sm font-medium text-gray-500">Titre</p>
                        <p class="mt-1 text-gray-900">{{ $question->title }}</p>
                        <p class="text-sm font-medium text-gray-500 mt-2">Description</p>
                        <p class="mt-1 text-gray-900">{{ $question->description }}</p>
                        <p class="text-sm font-medium text-gray-500 mt-2">Obligatoire</p>
                        <p class="mt-1 text-gray-900">{{ $question->is_required ? 'Oui' : 'Non' }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Aucune question n'est associée à ce formulaire.</p>
        @endif
    </div>
</div>
@endsection 