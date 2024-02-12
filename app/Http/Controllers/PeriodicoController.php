<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodico;
use App\Models\Disciplina;


class PeriodicoController extends Controller
{    
    public function index()
    {
        $periodicos = Periodico::with('disciplinas')->get();
        return view('periodicos.index', compact('periodicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $disciplinas = Disciplina::all();

        return view('periodicos.create', compact('disciplinas'));
    } 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255', // Garanta que 'tipo' seja validado corretamente.
            'descricao' => 'required',
            'disciplinas' => 'required|array',
        ]);
    
        $periodico = Periodico::create($request->all());
    
        $disciplinas = Disciplina::findMany($request->disciplinas);
        foreach ($disciplinas as $disciplina) {
            $periodico->disciplinas()->attach($disciplina->id, ['reservado' => false]);
        }
    
        return redirect()->route('periodicos.index')->with('success', 'Periódico adicionado com sucesso.');
    }    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required',
        ]);
    
        $periodico = Periodico::findOrFail($id);
        $periodico->update($request->all());
    
        return redirect()->route('periodicos.index')->with('success', 'Periódico atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $periodico = Periodico::findOrFail($id);
        $periodico->delete();
    
        return back()->with('success', 'Periódico removido com sucesso.');
    }
}
