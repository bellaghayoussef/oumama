@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier l'Étape</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.etaps.update', $etap) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $etap->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $etap->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="procedure_id">Procédure</label>
                            <select name="procedure_id" id="procedure_id" class="form-control @error('procedure_id') is-invalid @enderror" required>
                                <option value="">Sélectionner une procédure</option>
                                @foreach($procedures as $procedure)
                                    <option value="{{ $procedure->id }}" {{ old('procedure_id', $etap->procedure_id) == $procedure->id ? 'selected' : '' }}>
                                        {{ $procedure->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('procedure_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="delait">Délai (en jours)</label>
                            <input type="number" name="delait" id="delait" class="form-control @error('delait') is-invalid @enderror" value="{{ old('delait', $etap->delait) }}" min="1" required>
                            @error('delait')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            <a href="{{ route('admin.etaps.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 