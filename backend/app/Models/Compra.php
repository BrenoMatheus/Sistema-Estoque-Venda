<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;


    protected $fillable = [
        'data',
        'pessoa_id',
        'produto_id',
        'quantidade',
        'preco',
    ];

    public function Pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function Produto() {
        return $this->belongsTo(Produto::class);
    }
}
