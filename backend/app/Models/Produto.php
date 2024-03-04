<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;


    protected $fillable = [
        'nome',
        'descricao',
        'grupo_produto_id',
        'marca_id',
        'status',
        'quantidade',
        'preco',
    ];

    public function grupoProduto() {
        return $this->belongsTo(GrupoProduto::class, 'grupo_produto_id');
    }


    public function Marca() {
        return $this->belongsTo(Marca::class);
    }
}
