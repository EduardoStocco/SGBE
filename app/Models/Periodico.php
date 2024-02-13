<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodico extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'periodicos_user');
    }

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'disciplina_periodico');
    }

    protected $fillable = ['nome', 'tipo', 'descricao'];

}