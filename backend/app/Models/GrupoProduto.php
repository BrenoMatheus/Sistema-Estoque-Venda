<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoProduto extends Model
{
    use HasFactory;

    protected $table = 'grupo_produtos';

    protected $fillable = [
        'nome',
    ];

    public function Produtos()
    {
        return $this->hasMany(Produto::class);
    }

}
