@extends('admin.layouts.app')

@section('title', 'Remplir le Formulaire')
@section('header', 'Remplir le Formulaire')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ $form->name }}</h6>
            <a href="{{ route('admin.dossiers.show', $dossier) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Retour au Dossier
            </a>
        </div>

        <div class="card-body">
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <form action="{{ route('admin.dossiers.responses.store', $dossier) }}" method="POST" enctype="multipart/form-data">
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
@endsection
