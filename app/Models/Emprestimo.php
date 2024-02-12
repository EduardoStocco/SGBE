<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = ['titulo_id', 'user_id', 'data_emprestimo', 'data_prevista_devolucao', 'data_devolucao', 'multa'];

    public function calcularMulta() {
        $data_devolucao = $this->data_devolucao ? Carbon::parse($this->data_devolucao) : now();
        $data_prevista_devolucao = Carbon::parse($this->data_prevista_devolucao);
    
        if ($data_devolucao->gt($data_prevista_devolucao)) {
            $dias_de_atraso = $data_devolucao->diffInDays($data_prevista_devolucao);
            $valor_da_multa_por_dia = 1.00; // Defina o valor da multa por dia de atraso
            return $dias_de_atraso * $valor_da_multa_por_dia;
        }
    
        return 0;
    }

    public function titulo()
    {
        return $this->belongsTo(Titulo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
