@extends('admin.layouts.app')

@section('title', 'Modifier la Question')
@section('header', 'Modifier la Question')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.questions.update', $question) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <!-- Title Field -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titre de la Question</label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title', $question->title) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description"
                          id="description"
                          rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $question->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Required Field -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox"
                           name="is_required"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           {{ old('is_required', $question->is_required) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Question obligatoire</span>
                </label>
                @error('is_required')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit and Cancel Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.questions.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Mettre à jour
                </button>
            </div>
        </div>
    </form>
</div>
@endsection 