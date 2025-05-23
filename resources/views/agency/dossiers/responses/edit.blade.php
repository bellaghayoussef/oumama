@extends('agency.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Formulaire: {{ $response->formuler->name }}</h4>
                    <a href="{{ route('agency.dossiers.show', $dossier) }}" class="btn btn-secondary">Retour au dossier</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('agency.dossiers.responses.update', ['dossier' => $dossier->id, 'response' => $response->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @foreach($response->formuler->questions as $question)
                            <div class="form-group mb-3">
                                <label for="question_{{ $question->id }}" class="form-label">
                                    {{ $question->text }}
                                    @if($question->required)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>

                                @if($question->type === 'text')
                                    <input type="text"
                                           class="form-control @error('answers.'.$question->id) is-invalid @enderror"
                                           id="question_{{ $question->id }}"
                                           name="answers[{{ $question->id }}]"
                                           value="{{ old('answers.'.$question->id, $response->answers[$question->id] ?? '') }}"
                                           @if($question->required) required @endif>
                                @elseif($question->type === 'textarea')
                                    <textarea class="form-control @error('answers.'.$question->id) is-invalid @enderror"
                                              id="question_{{ $question->id }}"
                                              name="answers[{{ $question->id }}]"
                                              rows="3"
                                              @if($question->required) required @endif>{{ old('answers.'.$question->id, $response->answers[$question->id] ?? '') }}</textarea>
                                @elseif($question->type === 'select')
                                    <select class="form-control @error('answers.'.$question->id) is-invalid @enderror"
                                            id="question_{{ $question->id }}"
                                            name="answers[{{ $question->id }}]"
                                            @if($question->required) required @endif>
                                        <option value="">Sélectionnez une option</option>
                                        @foreach($question->options as $option)
                                            <option value="{{ $option }}"
                                                {{ old('answers.'.$question->id, $response->answers[$question->id] ?? '') == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif

                                @error('answers.'.$question->id)
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endforeach

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Soumettre les réponses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
