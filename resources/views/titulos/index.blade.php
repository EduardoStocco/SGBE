<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Títulos Disponíveis') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->isProfessor())
            <button onclick="window.location='{{ route('titulos.create') }}'" class="border border-blue-500 px-4 rounded">Adicionar Novo Título</button>
            @endif
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    Títulos disponíveis:
                    </h3>
                    <table class="table table-bordered w-full border">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Nome</th>
                                <th class="text-center border border-gray-300">Tipo</th>
                                <th class="text-center border border-gray-300">Descrição</th>
                                <th class="text-center border border-gray-300">Número de Exemplares</th>
                                <th class="text-center border border-gray-300">Período Máximo de Empréstimo</th>
                                <th class="text-center border border-gray-300">Disponível</th>
                                <th class="text-center border border-gray-300">Disciplina(s)</th>
                                <th class="text-center border border-gray-300">Ações</th>
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
                                <td class="text-center border border-gray-300">Sim</td>
                                <td class="text-center border border-gray-300">
                                    @foreach ($titulo->disciplinas as $disciplina)
                                        {{ $disciplina->nome }};<br>
                                    @endforeach
                                </td>
                                @if(Auth::user()->isProfessor())
                                <td class="text-center border border-gray-300">
                                    <!-- Adicione botões de ação como editar ou remover aqui -->
                                    <a href="{{ route('titulos.edit', $titulo->id) }}" class="border border-blue-500 px-4 rounded">Editar</a>

                                    <!-- Botão de exclusão com confirmação -->
                                    <form action="{{ route('titulos.destroy', $titulo->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 rounded hover:bg-red-600" onclick="return confirm('Tem certeza que deseja excluir este título?')">Excluir</button>
                                    </form>
                                </td>
                                @else
                                <td class="text-center border border-gray-300">
                                    <form action="{{ route('emprestimos.create') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="titulo_id" value="{{ $titulo->id }}">
                                        <button type="submit" class="border border-blue-500 px-4 rounded">Emprestar Título</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(Auth::user()->isProfessor())
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Não disponíveis no momento:
                    </h3>
                    <table class="table table-bordered w-full border">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Nome</th>
                                <th class="text-center border border-gray-300">Tipo</th>
                                <th class="text-center border border-gray-300">Descrição</th>
                                <th class="text-center border border-gray-300">Número de Exemplares</th>
                                <th class="text-center border border-gray-300">Período Máximo de Empréstimo</th>
                                <th class="text-center border border-gray-300">Disponível</th>
                                <th class="text-center border border-gray-300">Disciplina(s)</th>
                                <th class="text-center border border-gray-300">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($titulosIndisponiveis as $titulo)
                            <tr class="divide-x divide-gray-300">
                                <td class="text-center border border-gray-300">{{ $titulo->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->tipo }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->descricao }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->num_exemplares }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->periodo_maximo_emprestimo }} dias</td>
                                <td class="text-center border border-gray-300">Não</td>
                                <td class="text-center border border-gray-300">
                                    @foreach ($titulo->disciplinas as $disciplina)
                                        {{ $disciplina->nome }};<br>
                                    @endforeach
                                </td>
                                @if(Auth::user()->isProfessor())
                                <td class="text-center border border-gray-300">
                                    <!-- Adicione botões de ação como editar ou remover aqui -->
                                    <a href="{{ route('titulos.edit', $titulo->id) }}" class="border border-blue-500 px-4 rounded"><span class="underline">Editar</span></a>

                                    <!-- Botão de exclusão com confirmação -->
                                    <form action="{{ route('titulos.destroy', $titulo->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 rounded hover:bg-red-600" onclick="return confirm('Tem certeza que deseja excluir este título?')"><span class="underline">Excluir</span></button>
                                    </form>
                                </td>
                                @else
                                <td class="text-center border border-gray-300">
                                    <form action="{{ route('emprestimos.create') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="titulo_id" value="{{ $titulo->id }}">
                                        <button type="submit" class="border border-blue-500 px-4 rounded"><span class="underline">Emprestar Título</span></button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>     
        @endif   

    </div>
</x-app-layout>