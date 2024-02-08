@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Minhas Disciplinas</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('disciplinas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Disciplina</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Disciplina</button>
    </form>
    <hr>
    <ul class="list-group">
        @foreach ($disciplinas as $disciplina)
            <li class="list-group-item">{{ $disciplina->nome }}</li>
        @endforeach
    </ul>
</div>
@endsection