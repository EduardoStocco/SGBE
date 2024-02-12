<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;
use App\Models\Titulo;

class EmprestimoController extends Controller
{
    // Método para devolução de um Título
    public function devolver($id)
    {
        $emprestimo = Emprestimo::find($id);
        $emprestimo->data_devolucao = now(); // Marca a data atual como a de devolução
        $emprestimo->save();

        // Atualiza o status reservado do título para false
        $titulo = $emprestimo->titulo;
        $titulo->disponivel = true;
        $titulo->increment('num_exemplares');
        $titulo->save();

        return redirect()->route('emprestimos.index')->with('success', 'Título devolvido com sucesso.');
    }

    public function index()
    {
        $emprestimos = Emprestimo::with(['titulo', 'user'])->get();
        return view('emprestimos.index', compact('emprestimos'));
    }

    public function create()
    {
        $titulos = Titulo::all();
        return view('emprestimos.create', compact('titulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo_id' => 'required|exists:titulos,id',
            'data_emprestimo' => 'required|date',
            'data_prevista_devolucao' => 'required|date',
        ]);

        $emprestimo = new Emprestimo($request->all());
        $emprestimo->user_id = auth()->user()->id; // Assume que o usuário logado está fazendo o empréstimo
        $emprestimo->save();

        // Atualiza o status reservado do título
        $titulo = Titulo::find($request->titulo_id);

        $titulo = Titulo::find($request->titulo_id);
        if ($titulo && $titulo->num_exemplares > 0) {
            $titulo->decrement('num_exemplares');
            $titulo->save();
    
            return redirect()->route('emprestimos.index')->with('success', 'Empréstimo registrado com sucesso.');
            
        } else {
            return back()->with('error', 'Título não disponível.');
        }
    }

}
