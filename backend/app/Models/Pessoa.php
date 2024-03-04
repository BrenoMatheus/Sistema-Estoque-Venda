<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'grupo_pessoa_id',
        'genero',
        'idade',
    ];

    public function grupoPessoa() {
        return $this->belongsTo(GrupoPessoa::class, 'grupo_pessoa_id');
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'pessoa_id');
    }

}
