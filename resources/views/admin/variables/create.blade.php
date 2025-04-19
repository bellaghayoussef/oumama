@extends('admin.layouts.app')

@section('title', 'Créer une Variable')
@section('header', 'Créer une Variable')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.variables.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la Variable</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type"
                        id="type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    <option value="">Sélectionner un type</option>
                    <option value="string" {{ old('type') == 'string' ? 'selected' : '' }}>Texte</option>
                    <option value="bool" {{ old('type') == 'bool' ? 'selected' : '' }}>Booléen</option>
                    <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Nombre</option>
                    <option value="file" {{ old('type') == 'file' ? 'selected' : '' }}>Fichier</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="formuler_id" class="block text-sm font-medium text-gray-700">Formulaire</label>
                <select name="formuler_id"
                        id="formuler_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    <option value="">Sélectionner un formulaire</option>
                    @foreach($formulers as $formuler)
                        <option value="{{ $formuler->id }}" {{ old('formuler_id') == $formuler->id ? 'selected' : '' }}>
                            {{ $formuler->name }} ({{ $formuler->task->name }})
                        </option>
                    @endforeach
                </select>
                @error('formuler_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.variables.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Créer la Variable
                </button>
            </div>
        </div>
    </form>
</div>
@endsection 