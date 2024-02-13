<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Empréstimos') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Empréstimos Expirados/Multados:
                    </h3>

                    <table class="table table-bordered w-full border mt-3">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Título</th>
                                <th class="text-center border border-gray-300">Emprestado para</th>
                                <th class="text-center border border-gray-300">Data de Empréstimo</th>
                                <th class="text-center border border-gray-300">Data Prevista de Devolução</th>
                                <th class="text-center border border-gray-300">Devolvido em:</th>
                                <th class="text-center border border-gray-300">Multa</th>
                                <th class="text-center border border-gray-300">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emprestimosExpirados as $emprestimo)
                            <tr class="divide-x divide-gray-300">
                                <td class="text-center border border-gray-300">{{ $emprestimo->titulo->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $emprestimo->user->name }}</td>
                                <td class="text-center border border-gray-300">{{ \Carbon\Carbon::parse($emprestimo->data_emprestimo)->format('d/m/Y') }}</td>
                                <td class="text-center border border-gray-300">{{ \Carbon\Carbon::parse($emprestimo->data_prevista_devolucao)->format('d/m/Y') }}</td>
                                <td class="text-center border border-gray-300">
                                    @if($emprestimo->data_devolucao)
                                        {{ \Carbon\Carbon::parse($emprestimo->data_devolucao)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center border border-gray-300">{{ $emprestimo->multa }}</td>
                                <td class="text-center border border-gray-300">
                                    
                                    @if($emprestimo->multa > 0 && !$emprestimo->multa_paga)
                                        <form action="{{ route('emprestimos.pagarMulta', $emprestimo->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="border border-blue-500 px-4 rounded">Pagar Multa</button>
                                        </form>
                                    @endif

                                    @if($emprestimo->data_devolucao && !$emprestimo->perdido)
                                        Devolvido
                                    @elseif($emprestimo->perdido)
                                        Perdido
                                    @else
                                    <form action="{{ route('emprestimos.devolver', $emprestimo->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="border border-blue-500 px-4 rounded">Devolver</button>
                                    </form>
                                    @endif

                                    @if(!$emprestimo->perdido)
                                        <form action="{{ route('emprestimos.perdido', $emprestimo->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-500 text-white px-4 rounded hover:bg-red-600">Marcar como Perdido</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Meus empréstimos:
                    </h3>

                    <table class="table table-bordered w-full border mt-3">
                        <thead>
                            <tr>
                                <th class="text-center border border-gray-300">Título</th>
                                <th class="text-center border border-gray-300">Emprestado para</th>
                                <th class="text-center border border-gray-300">Data de Empréstimo</th>
                                <th class="text-center border border-gray-300">Data Prevista de Devolução</th>
                                <th class="text-center border border-gray-300">Devolvido em:</th>
                                <th class="text-center border border-gray-300">Devolução</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emprestimos as $emprestimo)
                            <tr class="divide-x divide-gray-300">
                                <td class="text-center border border-gray-300">{{ $emprestimo->titulo->nome }}</td>
                                <td class="text-center border border-gray-300">{{ $emprestimo->user->name }}</td>
                                <td class="text-center border border-gray-300">{{ \Carbon\Carbon::parse($emprestimo->data_emprestimo)->format('d/m/Y') }}</td>
                                <td class="text-center border border-gray-300">{{ \Carbon\Carbon::parse($emprestimo->data_prevista_devolucao)->format('d/m/Y') }}</td>
                                <td class="text-center border border-gray-300">
                                    @if($emprestimo->data_devolucao)
                                        {{ \Carbon\Carbon::parse($emprestimo->data_devolucao)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center border border-gray-300">
                                    <form action="{{ route('emprestimos.devolver', $emprestimo->id) }}" method="POST">
                                        @csrf
                                        @if($emprestimo->data_devolucao)
                                            OK
                                        @else
                                        <button type="submit" class="border border-blue-500 px-4 rounded">Devolver</button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>