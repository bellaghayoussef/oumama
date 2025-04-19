@extends('admin.layouts.app')

@section('title', 'Gérer les Réponses')
@section('header', 'Gérer les Réponses')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Liste des Réponses</h1>
    </div>
    <a href="{{ route('admin.repences.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-plus mr-2"></i> Nouvelle Réponse
    </a>
</div>

<!-- Search and Filters -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
    <form action="{{ route('admin.repences.index') }}" method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Rechercher une réponse..."
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-search mr-2"></i> Rechercher
        </button>
    </form>
</div>

<!-- Repences Table -->
<div class="bg-white rounded-lg shadow-md">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variable</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valeur</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Répondant</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($repences as $repence)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $repence->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $repence->variable->name }}</td>
                    <td class="px-6 py-4">{{ Str::limit($repence->value, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($repence->user_id)
                            Utilisateur: {{ $repence->user->name }}
                        @elseif($repence->agency_id)
                            Agence: {{ $repence->agency->name }}
                        @elseif($repence->admin_id)
                            Admin: {{ $repence->admin->name }}
                        @else
                            Non spécifié
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.repences.edit', $repence) }}" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.repences.show', $repence) }}" class="text-green-500 hover:text-green-700">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.repences.destroy', $repence) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t">
        {{ $repences->links() }}
    </div>
</div>
@endsection 