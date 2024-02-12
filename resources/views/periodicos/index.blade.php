<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Periódicos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(Auth::user()->isProfessor())
        <a href="{{ route('periodicos.create') }}" class="btn btn-primary mb-3">Adicionar Novo Periódico</a>
        @endif
        
        <table class="table table-bordered w-full border">
            <thead>
                <tr>
                    <th class="text-center border border-gray-300">Nome</th>
                    <th class="text-center border border-gray-300">Tipo</th>
                    <th class="text-center border border-gray-300">Descrição</th>
                    <th class="text-center border border-gray-300">Ínicio da Assinatura</th>
                    <th class="text-center border border-gray-300">Fim da Assinatura</th>
                    @if(Auth::user()->isProfessor())
                    <th class="text-center border border-gray-300">Ações</th>
                    @endif
                    <th class="text-center border border-gray-300">Disciplina(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($periodicos as $periodico)
                <tr class="divide-x divide-gray-300">
                    <td class="text-center border border-gray-300">{{ $periodico->nome }}</td>
                    <td class="text-center border border-gray-300">{{ $periodico->tipo }}</td>
                    <td class="text-center border border-gray-300">{{ $periodico->descricao }}</td>
                    <td class="text-center border border-gray-300">{{ $periodico->data_inicio_assinatura }}</td>
                    <td class="text-center border border-gray-300">{{ $periodico->data_fim_assinatura }}</td>
                    @if(Auth::user()->isProfessor())
                    <td class="text-center border border-gray-300">
                        <!-- Adicione botões de ação como editar ou remover aqui -->
                        <a href="{{ route('periodicos.edit', $periodico->id) }}" class="btn btn-primary mr-2">Editar</a>

                        <!-- Botão de exclusão com confirmação -->
                        <form action="{{ route('periodicos.destroy', $periodico->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este periódico?')">Excluir</button>
                        </form>
                    </td>
                    @endif
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
</x-app-layout>