<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adicionar Novo Título') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="{{ route('titulos.store') }}" method="POST">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>

                            <div class="form-group mb-4">
                                <label for="tipo">Tipo:</label>
                                <select class="form-control" id="tipo" name="tipo">
                                    <option value="Livro">Livro</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label for="descricao">Descrição:</label>
                                <textarea class="form-control" id="descricao" name="descricao"></textarea>
                            </div>

                            <div class="form-group mb-4">
                                <label for="num_exemplares">Número de Exemplares:</label>
                                <input type="number" class="form-control" id="num_exemplares" name="num_exemplares" required>
                            </div>

                            <div class="form-group mb-4">
                                <label for="periodo_maximo_emprestimo">Período Máximo de Empréstimo (dias):</label>
                                <input type="number" class="form-control" id="periodo_maximo_emprestimo" name="periodo_maximo_emprestimo" required>
                            </div>

                            <div class="form-group mb-4">
                                <label for="disponivel">Disponível:</label>
                                <select class="form-control" id="disponivel" name="disponivel">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
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

                            @if(Auth::user()->isProfessor())
                            <button type="submit" class="border border-blue-500 px-4 rounded">Adicionar Novo Título</button>
                            @endif
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>