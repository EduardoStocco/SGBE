<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    @if(Auth::user()->isProfessor())
    <div class="w-full py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Olá, Professor! Você está logado.") }}                
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Títulos reservados para suas disciplinas:</h3>
                    <table class="table table-bordered w-full border">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Nome</th>
                                <th class="text-center border border-gray-300">Tipo</th>
                                <th class="text-center border border-gray-300">Descrição</th>
                                <th class="text-center border border-gray-300">Ações</th>

                                <!-- Outras colunas conforme necessário -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($titulosReservados as $titulo)
                            <tr>
                                <td class="text-center border border-gray-300">{{ $titulo->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->tipo }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->descricao }}</td>
                                <td class="text-center border border-gray-300">
                                    <form action="{{ route('tornar.publico', $titulo->id) }}" method="POST">
                                        @csrf
                                        <button type="submit">Tornar Público Novamente</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>      
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Lista de Títulos:</h3>

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
                            @foreach ($titulosPermitidos as $titulo)
                            <tr class="divide-x divide-gray-300">
                                <td class="text-center border border-gray-300">{{ $titulo->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->tipo }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->descricao }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->num_exemplares }}</td>
                                <td class="text-center border border-gray-300">{{ $titulo->periodo_maximo_emprestimo }} dias</td>
                                <td class="text-center border border-gray-300">{{ $titulo->disponivel ? 'Sim' : 'Não' }}</td>
                                <td class="text-center border border-gray-300">
                                    @foreach ($titulo->disciplinas as $disciplina)
                                        {{ $disciplina->nome }};<br>
                                    @endforeach
                                </td>
                                <td class="text-center border border-gray-300">
                                    <form action="{{ route('reservar.titulo', $titulo->id) }}" method="POST">
                                        @csrf
                                        <button type="submit">Reservar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>      
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Lista de Periódicos:</h3>
                    <table class="table table-bordered w-full border">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Nome</th>
                                <th class="text-center border border-gray-300">Tipo</th>
                                <th class="text-center border border-gray-300">Descrição</th>
                                <th class="text-center border border-gray-300">Ínicio da Assinatura</th>
                                <th class="text-center border border-gray-300">Fim da Assinatura</th>
                                <th class="text-center border border-gray-300">Ações</th>
                                <th class="text-center border border-gray-300">Disciplina(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periodicosPermitidos as $periodico)
                            <tr class="divide-x divide-gray-300">
                                <td class="text-center border border-gray-300">{{ $periodico->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $periodico->tipo }}</td>
                                <td class="text-center border border-gray-300">{{ $periodico->descricao }}</td>
                                <td class="text-center border border-gray-300">{{ $periodico->data_inicio_assinatura }}</td>
                                <td class="text-center border border-gray-300">{{ $periodico->data_fim_assinatura }}</td>
                                <td class="text-center border border-gray-300">
                                    <form action="{{ route('reservar.periodico', $periodico->id) }}" method="POST">
                                        @csrf
                                        <button type="submit">Reservar</button>
                                    </form>              
                                </td>
                                <td class="text-center border border-gray-300">
                                    @foreach ($periodico->disciplinas as $disciplina)
                                        {{ $disciplina->nome }};<br>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>      
        </div>  
    </div>

    
    
    @else

    <div class="w-full py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Olá, Aluno! Você está logado.") }}              
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Títulos recomendados para suas disciplinas:</h3>
                    <table class="table table-bordered w-full border">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Nome</th>
                                <th class="text-center border border-gray-300">Tipo</th>
                                <th class="text-center border border-gray-300">Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recomendadoAlunos as $recomendado)
                            <tr>
                                <td class="text-center border border-gray-300">{{ $recomendado->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $recomendado->tipo }}</td>
                                <td class="text-center border border-gray-300">{{ $recomendado->descricao }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>      
        </div>
    </div>
    @endif
</x-app-layout>