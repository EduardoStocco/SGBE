<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Titulo;
use App\Models\Disciplina;

class TituloController extends Controller
{
    
    public function index()
    {
        $titulos = Titulo::where('disponivel', true)->get();
        $titulosIndisponiveis = Titulo::where('disponivel', false)->get();

        return view('titulos.index', compact('titulos', 'titulosIndisponiveis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'descricao' => 'required',
            'tipo' => 'required',
            'num_exemplares' => 'required|integer',
            'periodo_maximo_emprestimo' => 'required|integer',
            'disciplinas' => 'required|array',
        ]);

        $data = $request->all();
        $data['disponivel'] = $request->num_exemplares > 0; // Define 'disponivel' baseado em 'num_exemplares'

        $titulo = Titulo::create($data);

        $disciplinas = Disciplina::findMany($request->disciplinas);
        foreach ($disciplinas as $disciplina) {
            $titulo->disciplinas()->attach($disciplina->id, ['reservado' => false]); // Define 'reservado' como false ao anexar
        }

        return redirect()->route('titulos.index')->with('success', 'Título criado com sucesso.');
    }

    public function edit($id)
    {
        $titulo = Titulo::findOrFail($id);
        return view('titulos.edit', compact('titulo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // Validações
        ]);

        $titulo = Titulo::findOrFail($id);
        $titulo->update($request->all());

        return redirect()->route('titulos.index')->with('success', 'Título atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $titulo = Titulo::findOrFail($id);
        // Verificar empréstimos ativos antes de remover
        $titulo->delete();

        return back()->with('success', 'Título removido com sucesso.');
    }

    public function show($id)
    {
        $titulo = Titulo::with(['emprestimos', 'disciplinas'])->findOrFail($id);
        return view('titulos.show', compact('titulo'));
    }

    public function create()
    {
        $disciplinas = Disciplina::all();

        return view('titulos.create', compact('disciplinas'));
    }
}
