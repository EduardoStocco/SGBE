<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disciplina;

class DisciplinaController extends Controller
{

    // Exibe as disciplinas do professor
    public function index()
    {
/*         $user = auth()->user();
        $disciplinas = $user->isProfessor() ? $user->disciplinas : collect(); */

        $disciplinas = Disciplina::all();

        return view('disciplinas.index', compact('disciplinas'));
    }

    // Armazena uma nova disciplina ou atualiza uma existente
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        if ($user->isProfessor()) {
            // Cria uma nova disciplina
            $disciplina = Disciplina::create(['nome' => $request->nome]);

            // Associa a nova disciplina ao professor
            $user->disciplinas()->attach($disciplina->id);
        }

        return redirect()->route('disciplinas.index')->with('success', 'Disciplina salva com sucesso!');
    }

}
