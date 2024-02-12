<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Empréstimo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('emprestimos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="titulo_id">Título:</label>
                <select class="form-control" id="titulo_id" name="titulo_id">
                    @foreach ($titulos as $titulo)
                    <option value="{{ $titulo->id }}">{{ $titulo->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="data_emprestimo">Data de Empréstimo:</label>
                <input type="date" class="form-control" id="data_emprestimo" name="data_emprestimo" required>
            </div>
            <div class="form-group">
                <label for="data_prevista_devolucao">Data Prevista de Devolução:</label>
                <input type="date" class="form-control" id="data_prevista_devolucao" name="data_prevista_devolucao" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Empréstimo</button>
        </form>
    </div>
</x-app-layout>