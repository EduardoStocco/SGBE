<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;
use App\Models\Titulo;

use Carbon\Carbon;

class EmprestimoController extends Controller
{
    public function marcarComoPerdido($id)
    {
        $emprestimo = Emprestimo::find($id);
        $emprestimo->perdido = true;
        $emprestimo->multa += 50;
        $emprestimo->save();

        return redirect()->route('emprestimos.index')->with('success', 'Item marcado como perdido e estoque atualizado.');
    }

    public function emprestimosExpirados()
    {
        $hoje = Carbon::now()->toDateString(); // Formatar data para compatibilidade com SQL
    
        $emprestimosExpirados = Emprestimo::where('multa', '>', 0)
            ->orWhere('data_prevista_devolucao', '<', $hoje)
            ->orWhereRaw('data_devolucao > data_prevista_devolucao')
            ->get();
    
        return $emprestimosExpirados;
    }    

    public function pagarMulta($id)
    {
        $emprestimo = Emprestimo::find($id);
        $emprestimo->registrarPagamentoMulta();
        $emprestimo->multa = 0;
        $emprestimo->save();

        return redirect()->route('emprestimos.index')->with('success', 'Pagamento da multa registrado com sucesso.');
    }

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

        $multa = $emprestimo->calcularMulta();
        if ($multa > 0) {
            $emprestimo->multa = $multa;
            $emprestimo->save();

            return redirect()->route('emprestimos.index')->with('success', 'Título devolvido com sucesso. Multa aplicada: ' . $multa);
        }

        else {
            return redirect()->route('emprestimos.index')->with('success', 'Título devolvido com sucesso.');
        }
    }

    public function index()
    {
        $emprestimos = Emprestimo::with(['titulo', 'user'])->get();
        $emprestimosExpirados = $this->emprestimosExpirados();
        return view('emprestimos.index', compact('emprestimos', 'emprestimosExpirados'));
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
        ]);
    
        $titulo = Titulo::findOrFail($request->titulo_id);
    
        $emprestimo = new Emprestimo;
        $emprestimo->titulo_id = $request->titulo_id;
        $emprestimo->user_id = auth()->user()->id;
        $emprestimo->data_emprestimo = Carbon::now()->format('Y-m-d');
        $emprestimo->data_prevista_devolucao = Carbon::now()->addDays($titulo->periodo_maximo_emprestimo)->format('Y-m-d');
        $emprestimo->save();
    
        $titulo->decrement('num_exemplares');
        $titulo->refresh(); // Atualiza a instância com valores atuais do banco de dados.
    
        if ($titulo->num_exemplares < 1) {
            $titulo->disponivel = false;
            $titulo->save();
        }
    
        return redirect()->route('emprestimos.index')->with('success', 'Empréstimo registrado com sucesso.');
    }    

}
