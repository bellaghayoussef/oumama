@extends('admin.layouts.app')

@section('title', 'Modifier la Réponse')
@section('header', 'Modifier la Réponse')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ $form->name }}</h6>
            <a href="{{ route('admin.dossiers.responses.show', ['dossier' => $dossier->id, 'response' => $response->id]) }}"
               class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Retour à la Réponse
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.dossiers.responses.update', ['dossier' => $dossier->id, 'response' => $response->id]) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @php
                    $answers = $response->answers;
                @endphp

                @foreach($form->variables as $variable)
                    <div class="form-group mb-3">
                        <label for="answers[{{ $variable->id }}]" class="form-label">
                            {{ $variable->name }}
                            @if($variable->required)
                                <span class="text-danger">*</span>
                            @endif
                        </label>

                        @if($variable->type === 'text')
                            <input type="text"
                                   class="form-control @error('answers.'.$variable->id) is-invalid @enderror"
                                   id="answers[{{ $variable->id }}]"
                                   name="answers[{{ $variable->id }}]"
                                   value="{{ old('answers.'.$variable->id, $answers[$variable->id] ?? '') }}"
                                   @if($variable->required) required @endif>
                        @elseif($variable->type === 'textarea')
                            <textarea class="form-control @error('answers.'.$variable->id) is-invalid @enderror"
                                      id="answers[{{ $variable->id }}]"
                                      name="answers[{{ $variable->id }}]"
                                      rows="3"
                                      @if($variable->required) required @endif>{{ old('answers.'.$variable->id, $answers[$variable->id] ?? '') }}</textarea>
                        @elseif($variable->type === 'select')
                            <select class="form-control @error('answers.'.$variable->id) is-invalid @enderror"
                                    id="answers[{{ $variable->id }}]"
                                    name="answers[{{ $variable->id }}]"
                                    @if($variable->required) required @endif>
                                <option value="">Sélectionnez une option</option>
                                @foreach(json_decode($variable->options) as $option)
                                    <option value="{{ $option }}"
                                        {{ (old('answers.'.$variable->id, $answers[$variable->id] ?? '') == $option) ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        @elseif($variable->type === 'file')
                            @if(isset($answers[$variable->id]))
                                <div class="mb-2">
                                    <a href="{{ Storage::url($answers[$variable->id]) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-download"></i> Fichier actuel
                                    </a>
                                </div>
                            @endif
                            <input type="file"
                                   class="form-control @error('answers.'.$variable->id) is-invalid @enderror"
                                   id="answers[{{ $variable->id }}]"
                                   name="answers[{{ $variable->id }}]"
                                   @if($variable->required && !isset($answers[$variable->id])) required @endif>
                            <small class="form-text text-muted">Laissez vide pour conserver le fichier actuel</small>
                        @endif

                        @error('answers.'.$variable->id)
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endforeach

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à Jour les Réponses
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
