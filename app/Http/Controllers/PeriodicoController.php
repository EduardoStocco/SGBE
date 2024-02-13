<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodico;
use App\Models\Disciplina;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class PeriodicoController extends Controller
{   
    public function index()
    {
        $userId = auth()->user()->id;
        $userDisciplinasIds = auth()->user()->disciplinas()->pluck('id')->toArray();

        // Assinaturas Ativas
        $assinaturasAtivas = Periodico::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId)
                ->whereNull('periodicos_user.data_fim_assinatura');
        })->get();

        // Periódicos Permitidos (não reservados e não assinados)
        $periodicosPermitidos = Periodico::whereDoesntHave('disciplinas', function ($query) use ($userDisciplinasIds) {
            $query->where('disciplina_periodico.reservado', true)
                ->whereNotIn('disciplina_id', $userDisciplinasIds);
        })->whereDoesntHave('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->get();

        $periodicos = Periodico::all();

        // Para assinaturas canceladas
        $assinaturasCanceladas = Periodico::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId)
                ->whereNotNull('periodicos_user.data_fim_assinatura');
        })->get();

        return view('periodicos.index', compact('assinaturasAtivas', 'periodicosPermitidos', 'periodicos', 'assinaturasCanceladas'));
    }

    public function ativarAssinatura(Request $request, $periodicoId)
    {
        $userId = Auth::id(); // Obtém o ID do usuário logado
    
        // Busca por qualquer assinatura existente, ativa ou não
        $assinaturaExistente = Periodico::whereHas('users', function ($query) use ($userId, $periodicoId) {
            $query->where('users.id', $userId);
        })->find($periodicoId);
    
        if ($assinaturaExistente) {
            // Verifica se a assinatura está ativa
            $assinaturaAtiva = $assinaturaExistente->users()->where('user_id', $userId)->whereNull('periodicos_user.data_fim_assinatura')->first();
            
            if ($assinaturaAtiva) {
                return back()->with('error', 'Você já possui uma assinatura ativa para este periódico.');
            } else {
                // Reativa uma assinatura existente definindo data_fim_assinatura como null
                $assinaturaExistente->users()->updateExistingPivot($userId, [
                    'data_inicio_assinatura' => Carbon::now(), // Opcionalmente atualizar data_inicio_assinatura
                    'data_fim_assinatura' => null,
                ]);
                return back()->with('success', 'Assinatura reativada com sucesso.');
            }
        } else {
            // Cria uma nova assinatura se não houver assinatura prévia
            $periodico = Periodico::find($periodicoId);
            $periodico->users()->attach($userId, [
                'data_inicio_assinatura' => Carbon::now(),
                'data_fim_assinatura' => null, // Assinatura ativa
            ]);
    
            return back()->with('success', 'Assinatura ativada com sucesso.');
        }
    }    

    public function cancelarAssinatura(Request $request, $periodicoId)
    {
        $userId = Auth::id(); // Obtém o ID do usuário logado
    
        $periodico = Periodico::find($periodicoId);
        
        // Atualiza a assinatura para definir a data de fim como agora, cancelando-a
        if ($periodico) {
            $periodico->users()->updateExistingPivot($userId, [
                'data_fim_assinatura' => Carbon::now(),
            ]);
    
            return back()->with('success', 'Assinatura cancelada com sucesso.');
        } else {
            return back()->with('error', 'Não foi possível encontrar o periódico especificado.');
        }
    }

    public function create()
    {
        $disciplinas = Disciplina::all();

        return view('periodicos.create', compact('disciplinas'));
    } 

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
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

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $periodico = Periodico::findOrFail($id);
        return view('periodicos.edit', compact('periodico'));
    }

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

    public function destroy($id)
    {
        $periodico = Periodico::findOrFail($id);
        $periodico->delete();
    
        return back()->with('success', 'Periódico removido com sucesso.');
    }
}
