<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar este Periódico') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="{{ route('periodicos.update', $periodico->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group mb-4">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{ $periodico->nome }}" required>
                            </div>
                            
                            <div class="form-group mb-4">
                                <label for="tipo">Tipo:</label>
                                <select class="form-control" id="tipo" name="tipo">
                                    <option value="Revista" {{ $periodico->tipo == 'Revista' ? 'selected' : '' }}>Revista</option>
                                    <option value="Jornal" {{ $periodico->tipo == 'Jornal' ? 'selected' : '' }}>Jornal</option>
                                </select>
                            </div>
                            
                            <div class="form-group mb-4">
                                <label for="descricao">Descrição:</label>
                                <textarea class="form-control" id="descricao" name="descricao">{{ $periodico->descricao }}</textarea>
                            </div>
                            
                            <button type="submit" class="border border-blue-500 px-4 rounded">Atualizar</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>