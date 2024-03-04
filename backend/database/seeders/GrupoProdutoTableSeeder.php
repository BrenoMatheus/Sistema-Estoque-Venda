<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GrupoProdutoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('grupo_produtos')->insert([
            ['nome' => 'Roupa'],
            ['nome' => 'Calçado'],
            ['nome' => 'Acessorio']
        ]);
    }
}
