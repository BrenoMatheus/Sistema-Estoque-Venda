<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PessoaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pessoas = [
            ['nome' => 'João', 'grupo_pessoa_id' => 1, 'genero' => 'Masculino', 'idade' => 25],
            ['nome' => 'Pedro', 'grupo_pessoa_id' => 1, 'genero' => 'Masculino', 'idade' => 35],
            ['nome' => 'Lucas', 'grupo_pessoa_id' => 1, 'genero' => 'Masculino', 'idade' => 29],
            ['nome' => 'José', 'grupo_pessoa_id' => 1, 'genero' => 'Masculino', 'idade' => 40],
            ['nome' => 'Carlos', 'grupo_pessoa_id' => 1, 'genero' => 'Masculino', 'idade' => 27],
            ['nome' => 'Ana', 'grupo_pessoa_id' => 1, 'genero' => 'Feminino', 'idade' => 28],
            ['nome' => 'Maria', 'grupo_pessoa_id' => 1, 'genero' => 'Feminino', 'idade' => 30],
            ['nome' => 'Mariana', 'grupo_pessoa_id' => 2, 'genero' => 'Feminino', 'idade' => 22],
            ['nome' => 'Beatriz', 'grupo_pessoa_id' => 2, 'genero' => 'Feminino', 'idade' => 33],
            ['nome' => 'Juliana', 'grupo_pessoa_id' => 2, 'genero' => 'Feminino', 'idade' => 31],


        ];

        // Inserindo os registros na tabela 'pessoas'
        DB::table('pessoas')->insert($pessoas);

    }
}
