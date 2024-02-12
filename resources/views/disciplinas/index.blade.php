<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Disciplinas') }}
        </h2>
    </x-slot>

    <div class="py-12">
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

</x-app-layout>