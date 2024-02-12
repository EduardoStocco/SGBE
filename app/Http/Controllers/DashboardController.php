<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\{Titulo, Periodico, Disciplina, User};

class DashboardController extends Controller
{    
    public function reservarTitulo(Request $request, $tituloId)
    {
        $user = Auth::user();
        $disciplinaIds = $user->disciplinas()->pluck('id');

        $titulo = Titulo::findOrFail($tituloId);
        // Associar o título às disciplinas do professor marcando como reservado
        $titulo->disciplinas()->syncWithoutDetaching($disciplinaIds->mapWithKeys(function ($id) {
            return [$id => ['reservado' => true]];
        }));

        return back()->with('success', 'Título reservado com sucesso.');
    }

    public function reservarPeriodico(Request $request, $periodicoId)
    {
        $user = Auth::user();
        $disciplinaIds = $user->disciplinas()->pluck('id');

        $periodico = Periodico::findOrFail($periodicoId);
        // Associar o periódico às disciplinas do professor marcando como reservado
        $periodico->disciplinas()->syncWithoutDetaching($disciplinaIds->mapWithKeys(function ($id) {
            return [$id => ['reservado' => true]];
        }));

        return back()->with('success', 'Periódico reservado com sucesso.');
    }

    public function tornarPublico(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->isProfessor()) {
            // Tenta encontrar o título ou periódico pelo ID
            $titulo = Titulo::find($id);
            $periodico = Periodico::find($id);

            if ($titulo) {
                // Obter IDs das disciplinas do usuário como array simples
                $disciplinasIds = $user->disciplinas()->pluck('id')->toArray();
                // Atualizar para cada disciplina do título para 'reservado' => false
                foreach ($disciplinasIds as $disciplinaId) {
                    $titulo->disciplinas()->updateExistingPivot($disciplinaId, ['reservado' => false]);
                }
                return back()->with('success', 'Título tornado público com sucesso.');
            } elseif ($periodico) {
                // Obter IDs das disciplinas do usuário como array simples
                $disciplinasIds = $user->disciplinas()->pluck('id')->toArray();
                // Atualizar para cada disciplina do periódico para 'reservado' => false
                foreach ($disciplinasIds as $disciplinaId) {
                    $periodico->disciplinas()->updateExistingPivot($disciplinaId, ['reservado' => false]);
                }
                return back()->with('success', 'Periódico tornado público com sucesso.');
            }            
        } else {
            return back()->with('error', 'Ação permitida apenas para professores.');
        }
    }

    public function titulosPermitidos() {
        // Seleciona todos os títulos que têm pelo menos uma disciplina associada marcada como reservada.
        $titulos = Titulo::whereHas('disciplinas', function ($query) {
            $query->where('disciplina_titulo.reservado', false); // 'disciplina_titulo' é o nome da tabela pivot
        })->get();
    
        return $titulos;
    }
    
    public function periodicosPermitidos() {
        $periodicos = Periodico::whereHas('disciplinas', function ($query) {
            $query->where('disciplina_periodico.reservado', false);
        })->get();
    
        return $periodicos;
    }

    public function titulosReservados($userId) {
        $userDisciplinasIds = Auth::user()->disciplinas()->pluck('id')->toArray();
    
        $titulosReservados = Titulo::whereHas('disciplinas', function ($query) {
            $query->where('disciplina_titulo.reservado', true);
        })->get();
    
        $periodicosReservados = Periodico::whereHas('disciplinas', function ($query) {
            $query->where('disciplina_periodico.reservado', true);
        })->get();
    
        $resultados = $titulosReservados->merge($periodicosReservados);
    
        return $resultados;
    }    

    public function index()
    {
        $user = Auth::user();
        $titulosPermitidos = collect();
        $periodicosPermitidos = collect();
        $titulosReservados = collect();
        $recomendadoAlunos = collect();

        if ($user->isProfessor()) {
            $titulosPermitidos = $this->titulosPermitidos();
            $periodicosPermitidos = $this->periodicosPermitidos();
            $titulosReservados = $this->titulosReservados($user->id);

            return view('dashboard', compact('titulosPermitidos', 'periodicosPermitidos', 'titulosReservados'));
        }
        else {
            $recomendadoAlunos = $this->titulosReservados($user->id);

            return view('dashboard', compact('recomendadoAlunos'));
        }
    }
}