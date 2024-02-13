<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Periódicos') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <!-- VIEW PARA PROFESSORES -->
        @if(Auth::user()->isProfessor())
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <button onclick="window.location='{{ route('periodicos.create') }}'" class="border border-blue-500 px-4 rounded">Adicionar Novo Periódico</button>
        </div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    Lista de Periódicos:
                    </h3>
                    <table class="table table-bordered w-full border">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Nome</th>
                                <th class="text-center border border-gray-300">Tipo</th>
                                <th class="text-center border border-gray-300">Descrição</th>
                                <th class="text-center border border-gray-300">Disciplina(s)</th>
                                <th class="text-center border border-gray-300">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periodicos as $periodico)
                            <tr class="divide-x divide-gray-300">
                                <td class="text-center border border-gray-300">{{ $periodico->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $periodico->tipo }}</td>
                                <td class="text-center border border-gray-300">{{ $periodico->descricao }}</td>
                                <td class="text-center border border-gray-300">
                                    @foreach ($periodico->disciplinas as $disciplina)
                                        {{ $disciplina->nome }};<br>
                                    @endforeach
                                </td>

                                <td class="text-center border border-gray-300">
                                    <a href="{{ route('periodicos.edit', $periodico->id) }}" class="border border-blue-500 px-4 rounded">Editar</a>

                                    <!-- Botão de exclusão com confirmação -->
                                    <form action="{{ route('periodicos.destroy', $periodico->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 rounded hover:bg-red-600" onclick="return confirm('Tem certeza que deseja excluir este periódico?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- VIEW PARA ALUNOS -->
        @else
        <!-- Tabela de Assinaturas Ativas -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">          
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Suas Assinaturas Ativas:
                    </h3>          
                    <table class="table table-bordered w-full border">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Nome</th>
                                <th class="text-center border border-gray-300">Tipo</th>
                                <th class="text-center border border-gray-300">Descrição</th>
                                <th class="text-center border border-gray-300">Ínicio da Assinatura</th>
                                <th class="text-center border border-gray-300">Fim da Assinatura</th>
                                <th class="text-center border border-gray-300">Disciplina(s)</th>
                                <th class="text-center border border-gray-300">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assinaturasAtivas as $assinatura)
                            <tr class="divide-x divide-gray-300">
                                <td class="text-center border border-gray-300">{{ $assinatura->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $assinatura->tipo }}</td>
                                <td class="text-center border border-gray-300">{{ $assinatura->descricao }}</td>
                                <td class="text-center border border-gray-300">{{ \Carbon\Carbon::parse($assinatura->data_inicio_assinatura)->format('d/m/Y') }}</td>
                                <td class="text-center border border-gray-300">{{ \Carbon\Carbon::parse($assinatura->data_fim_assinatura)->format('d/m/Y') }}</td>
                                <td class="text-center border border-gray-300">
                                    @foreach ($assinatura->disciplinas as $disciplina)
                                        {{ $disciplina->nome }};<br>
                                    @endforeach
                                </td>
                                <td class="text-center border border-gray-300">
                                    <form action="{{ route('periodicos.cancelar', $assinatura->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 rounded hover:bg-red-600">Cancelar Assinatura</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Assinaturas Canceladas -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">            
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Assinaturas Canceladas:
                    </h3>        
                    <table class="table table-bordered w-full border">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Nome</th>
                                <th class="text-center border border-gray-300">Tipo</th>
                                <th class="text-center border border-gray-300">Descrição</th>
                                <th class="text-center border border-gray-300">Ínicio da Assinatura</th>
                                <th class="text-center border border-gray-300">Fim da Assinatura</th>
                                <th class="text-center border border-gray-300">Disciplina(s)</th>
                                <th class="text-center border border-gray-300">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assinaturasCanceladas as $assinatura)
                            <tr class="divide-x divide-gray-300">
                                <td class="text-center border border-gray-300">{{ $assinatura->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $assinatura->tipo }}</td>
                                <td class="text-center border border-gray-300">{{ $assinatura->descricao }}</td>
                                <td class="text-center border border-gray-300">{{ \Carbon\Carbon::parse($assinatura->data_inicio_assinatura)->format('d/m/Y') }}</td>
                                <td class="text-center border border-gray-300">{{ \Carbon\Carbon::parse($assinatura->data_fim_assinatura)->format('d/m/Y') }}</td>
                                <td class="text-center border border-gray-300">
                                    @foreach ($assinatura->disciplinas as $disciplina)
                                        {{ $disciplina->nome }};<br>
                                    @endforeach
                                </td>
                                <td class="text-center border border-gray-300">
                                    <form action="{{ route('periodicos.ativar', $assinatura->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="border border-blue-500 px-4 rounded">Ativar Novamente a Assinatura</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Tabela de Periódicos Permitidos -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Disponíveis para Assinar:
                    </h3>
                    <table class="table table-bordered w-full border">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Nome</th>
                                <th class="text-center border border-gray-300">Tipo</th>
                                <th class="text-center border border-gray-300">Descrição</th>
                                <th class="text-center border border-gray-300">Disciplina(s)</th>
                                <th class="text-center border border-gray-300">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periodicosPermitidos as $periodico)
                            <tr class="divide-x divide-gray-300">
                                <td class="text-center border border-gray-300">{{ $periodico->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $periodico->tipo }}</td>
                                <td class="text-center border border-gray-300">{{ $periodico->descricao }}</td>
                                <td class="text-center border border-gray-300">
                                    @foreach ($periodico->disciplinas as $disciplina)
                                        {{ $disciplina->nome }};<br>
                                    @endforeach
                                </td>
                                <td class="text-center border border-gray-300">
                                    <form action="{{ route('periodicos.ativar', $periodico->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="border border-blue-500 px-4 rounded">Ativar Assinatura</button>
                                    </form>
                                </td>
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