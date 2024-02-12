<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Títulos Disponíveis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(Auth::user()->isProfessor())
        <a href="{{ route('titulos.create') }}" class="btn btn-primary mb-3">Adicionar Novo Título</a>
        @endif
        
        <table class="table table-bordered w-full border">
            <thead>
                <tr>
                    <th class="text-center border border-gray-300">Nome</th>
                    <th class="text-center border border-gray-300">Tipo</th>
                    <th class="text-center border border-gray-300">Descrição</th>
                    <th class="text-center border border-gray-300">Número de Exemplares</th>
                    <th class="text-center border border-gray-300">Período Máximo de Empréstimo</th>
                    <th class="text-center border border-gray-300">Disponível</th>
                    @if(Auth::user()->isProfessor())
                    <th class="text-center border border-gray-300">Ações</th>
                    @endif
                    <th class="text-center border border-gray-300">Disciplina(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($titulos as $titulo)
                <tr class="divide-x divide-gray-300">
                    <td class="text-center border border-gray-300">{{ $titulo->nome }}</td>
                    <td class="text-center border border-gray-300">{{ $titulo->tipo }}</td>
                    <td class="text-center border border-gray-300">{{ $titulo->descricao }}</td>
                    <td class="text-center border border-gray-300">{{ $titulo->num_exemplares }}</td>
                    <td class="text-center border border-gray-300">{{ $titulo->periodo_maximo_emprestimo }} dias</td>
                    <td class="text-center border border-gray-300">{{ $titulo->disponivel ? 'Sim' : 'Não' }}</td>
                    @if(Auth::user()->isProfessor())
                    <td class="text-center border border-gray-300">
                        <!-- Adicione botões de ação como editar ou remover aqui -->
                        <a href="{{ route('titulos.edit', $titulo->id) }}" class="btn btn-primary mr-2">Editar</a>

                        <!-- Botão de exclusão com confirmação -->
                        <form action="{{ route('titulos.destroy', $titulo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este título?')">Excluir</button>
                        </form>
                    </td>
                    @endif
                    <td class="text-center border border-gray-300">
                        @foreach ($titulo->disciplinas as $disciplina)
                            {{ $disciplina->nome }};<br>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>