<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    // relacionamento com usuários (tabela pivot)
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    protected $fillable = [
        'nome',
    ];

}
