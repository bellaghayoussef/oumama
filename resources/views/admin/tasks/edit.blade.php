@extends('admin.layouts.app')

@section('title', 'Modifier la Tâche')
@section('header', 'Modifier la Tâche')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la Tâche</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $task->name) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description"
                          id="description"
                          rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="etap_id" class="block text-sm font-medium text-gray-700">Étape</label>
                <select name="etap_id"
                        id="etap_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    <option value="">Sélectionner une étape</option>
                    @foreach($etaps as $etap)
                        <option value="{{ $etap->id }}" {{ old('etap_id', $task->etap_id) == $etap->id ? 'selected' : '' }}>
                            {{ $etap->name }} ({{ $etap->procedure->name }})
                        </option>
                    @endforeach
                </select>
                @error('etap_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="intervenant" class="block text-sm font-medium text-gray-700">Intervenant</label>
                <select name="intervenant"
                        id="intervenant"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    <option value="">Sélectionner un intervenant</option>
                    <option value="admin" {{ old('intervenant', $task->intervenant) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="agence" {{ old('intervenant', $task->intervenant) == 'agence' ? 'selected' : '' }}>Agence</option>
                    <option value="user" {{ old('intervenant', $task->intervenant) == 'user' ? 'selected' : '' }}>Utilisateur</option>
                </select>
                @error('intervenant')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="delait" class="block text-sm font-medium text-gray-700">Délai (en jours)</label>
                <input type="number"
                       name="delait"
                       id="delait"
                       value="{{ old('delait', $task->delait) }}"
                       min="1"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
                @error('delait')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.tasks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Mettre à jour
                </button>
            </div>
        </div>
    </form>
</div>
@endsection 