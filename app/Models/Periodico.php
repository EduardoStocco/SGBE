<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodico extends Model
{
    use HasFactory;

    // Em App\Models\Periodico.php

    public function ativarAssinatura() {
        $this->ativo = true;
        $this->save();
    }

    public function cancelarAssinatura() {
        $this->ativo = false;
        $this->save();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'disciplina_periodico');
    }

    protected $fillable = ['nome', 'tipo', 'descricao', 'data_inicio_assinatura', 'data_fim_assinatura'];

}
