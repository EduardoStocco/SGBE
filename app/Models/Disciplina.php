<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    // Em App\Models\Disciplina.php

    public function reservarTitulo(Titulo $titulo) {
        $this->titulos()->attach($titulo->id, ['reservado' => true]);
    }

    public function revogarTitulo(Titulo $titulo) {
        $this->titulos()->updateExistingPivot($titulo->id, ['reservado' => false]);
    }

    public function reservarPeriodico(Periodico $periodico) {
        $this->periodicos()->attach($periodico->id, ['reservado' => true]);
    }

    public function revogarPeriodico(Periodico $periodico) {
        $this->periodicos()->updateExistingPivot($periodico->id, ['reservado' => false]);
    }

    // relacionamento com Títulos
    public function titulos()
    {
        return $this->belongsToMany(Titulo::class, 'disciplina_titulo');
    }
    
    // relacionamento com usuários (tabela pivot)
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    protected $fillable = [
        'nome',
    ];

}
