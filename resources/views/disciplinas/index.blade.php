<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Disciplinas') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        @if(Auth::user()->isProfessor())
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('disciplinas.store') }}" method="POST">
                        @csrf
                        <label for="nome" class="form-label">Nome da Disciplina</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                        <button type="submit" class="border border-blue-500 px-4 rounded">Salvar Disciplina</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Suas Disciplinas:
                    </h3>
                    <ul class="list-group">
                        @foreach ($disciplinas as $disciplina)
                            <li class="list-group-item">{{ $disciplina->nome }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>