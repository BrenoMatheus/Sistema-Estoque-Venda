<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MarcaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marcas')->insert([
            ['nome' => 'Adidas'],
            ['nome' => 'Nike'],
            ['nome' => 'Puma'],
            ['nome' => 'Reebok'],
            ['nome' => 'Under Armour']
        ]);

    }
}
