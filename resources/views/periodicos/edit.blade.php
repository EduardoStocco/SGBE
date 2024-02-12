<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar este Periódico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <h1>Editar Título</h1>
        <form action="{{ route('periodicos.update', $periodico->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $periodico->nome }}" required>
            </div>
            
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select class="form-control" id="tipo" name="tipo">
                    <option value="Revista" {{ $periodico->tipo == 'Revista' ? 'selected' : '' }}>Revista</option>
                    <option value="Jornal" {{ $periodico->tipo == 'Jornal' ? 'selected' : '' }}>Jornal</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao">{{ $periodico->descricao }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>
</x-app-layout>