<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titulo extends Model
{
    use HasFactory;  

    protected $fillable = [
        'nome', 'tipo', 'descricao', 'num_exemplares', 'periodo_maximo_emprestimo', 'disponivel'
    ];

    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'disciplina_titulo');
    }
}
