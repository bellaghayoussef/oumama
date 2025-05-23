@extends('agency.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Formulaire: {{ $form->name }}</h4>
                    <a href="{{ route('agency.dossiers.show', $dossier) }}" class="btn btn-secondary">Retour au dossier</a>
                </div>
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                <div class="card-body">
                    <form action="{{ route('agency.dossiers.responses.store', $dossier) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="formuler_id" value="{{ $form->id }}">

                        @foreach($form->variables as $question)

                            <div class="form-group mb-3">
                                <label for="question_{{ $question->id }}" class="form-label">
                                    @if($question->name)
                               {{ $question->name }}
                                @endif
                                </label>


                                <input type="{{ $question->type }}" name="answers[{{ $question->id }}]" id="question_{{ $question->id }}" class="form-control" placeholder="{{ $question->name }}">


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
