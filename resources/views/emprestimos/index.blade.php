<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Empréstimos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <a href="{{ route('emprestimos.create') }}" class="btn btn-primary">Novo Empréstimo</a>

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
                    <td class="text-center border border-gray-300">{{ \Carbon\Carbon::parse($emprestimo->data_devolucao)->format('d/m/Y') }}</td>
                    <td class="text-center border border-gray-300">
                        <form action="{{ route('emprestimos.devolver', $emprestimo->id) }}" method="POST">
                            @csrf
                            <button type="submit">Devolver</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>