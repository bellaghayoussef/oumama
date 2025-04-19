@extends('admin.layouts.app')

@section('title', 'Modifier la Réponse')
@section('header', 'Modifier la Réponse')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.repences.update', $repence) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label for="variable_id" class="block text-sm font-medium text-gray-700">Variable</label>
                <select name="variable_id"
                        id="variable_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    <option value="">Sélectionner une variable</option>
                    @foreach($variables as $variable)
                        <option value="{{ $variable->id }}" {{ old('variable_id', $repence->variable_id) == $variable->id ? 'selected' : '' }}>
                            {{ $variable->name }} ({{ $variable->formuler->name }})
                        </option>
                    @endforeach
                </select>
                @error('variable_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="value" class="block text-sm font-medium text-gray-700">Valeur</label>
                <textarea name="value"
                          id="value"
                          rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          required>{{ old('value', $repence->value) }}</textarea>
                @error('value')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Utilisateur</label>
                <select name="user_id"
                        id="user_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionner un utilisateur</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $repence->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="agency_id" class="block text-sm font-medium text-gray-700">Agence</label>
                <select name="agency_id"
                        id="agency_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionner une agence</option>
                    @foreach($agencies as $agency)
                        <option value="{{ $agency->id }}" {{ old('agency_id', $repence->agency_id) == $agency->id ? 'selected' : '' }}>
                            {{ $agency->name }}
                        </option>
                    @endforeach
                </select>
                @error('agency_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="admin_id" class="block text-sm font-medium text-gray-700">Admin</label>
                <select name="admin_id"
                        id="admin_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionner un admin</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ old('admin_id', $repence->admin_id) == $admin->id ? 'selected' : '' }}>
                            {{ $admin->name }}
                        </option>
                    @endforeach
                </select>
                @error('admin_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.repences.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
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