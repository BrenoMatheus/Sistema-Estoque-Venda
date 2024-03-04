<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoPessoa extends Model
{
    use HasFactory;

    protected $table = 'grupo_pessoas';

    protected $fillable = [
        'nome',
    ];

    /* public function pessoa() {
        return $this->belongsToMany(Pessoa::class, 'grupo_pessoa_id', 'id');
    } */
}
