@extends('admin.layouts.app')

@section('title', 'Modifier le Dossier')
@section('header', 'Modifier le Dossier')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.dossiers.update', $dossier) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Procédure -->
            <div class="col-span-1">
                <label for="procedure_id" class="block text-sm font-medium text-gray-700">Procédure</label>
                <select name="procedure_id" id="procedure_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionner une procédure</option>
                    @foreach($procedures as $procedure)
                        <option value="{{ $procedure->id }}" {{ old('procedure_id', $dossier->procedure_id) == $procedure->id ? 'selected' : '' }}>
                            {{ $procedure->title }}
                        </option>
                    @endforeach
                </select>
                @error('procedure_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Agence -->
            <div class="col-span-1">
                <label for="agency_id" class="block text-sm font-medium text-gray-700">Agence</label>
                <select name="agency_id" id="agency_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionner une agence</option>
                    @foreach($agencies as $agency)
                        <option value="{{ $agency->id }}" {{ old('agency_id', $dossier->agency_id) == $agency->id ? 'selected' : '' }}>
                            {{ $agency->name }}
                        </option>
                    @endforeach
                </select>
                @error('agency_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Utilisateur -->
            <div class="col-span-1">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Utilisateur</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionner un utilisateur</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $dossier->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tâche -->
            <div class="col-span-1">
                <label for="task_id" class="block text-sm font-medium text-gray-700">Tâche</label>
                <select name="task_id" id="task_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionner une tâche</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}" {{ old('task_id', $dossier->task_id) == $task->id ? 'selected' : '' }}>
                            {{ $task->title }}
                        </option>
                    @endforeach
                </select>
                @error('task_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Statut -->
            <div class="col-span-1">
                <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="en_attente" {{ old('status', $dossier->status) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="en_cours" {{ old('status', $dossier->status) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="termine" {{ old('status', $dossier->status) == 'termine' ? 'selected' : '' }}>Terminé</option>
                    <option value="rejete" {{ old('status', $dossier->status) == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.dossiers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
                Annuler
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection 