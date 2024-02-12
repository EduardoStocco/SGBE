<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Novo Periódico') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <form action="{{ route('periodicos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select class="form-control" id="tipo" name="tipo">
                    <option value="Livro">Revista</option>
                    <option value="Outro">Jornal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao"></textarea>
            </div>

            <div class="form-group">
                <label for="disciplinas">Disciplinas Associadas:</label>
                @foreach ($disciplinas as $disciplina)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $disciplina->id }}" name="disciplinas[]" id="disciplina_{{ $disciplina->id }}">
                        <label class="form-check-label" for="disciplina_{{ $disciplina->id }}">
                            {{ $disciplina->nome }}
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Adicionar Periódico</button>
        </form>
    </div>
</x-app-layout>