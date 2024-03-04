<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdutoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produtos = [
            [
                'nome' => 'Moletom Esportivo',
                'descricao' => 'Moletom esportivo cinza',
                'grupo_produto_id' => 1, // Roupa
                'marca_id' => 3, // Puma
                'status' => true,
                'quantidade' => 60,
                'preco' => 79.99
            ],
            [
                'nome' => 'Tênis de Basquete',
                'descricao' => 'Tênis de basquete vermelho',
                'grupo_produto_id' => 2, // Calçado
                'marca_id' => 4, // Reebok
                'status' => true,
                'quantidade' => 20,
                'preco' => 149.99
            ],
            [
                'nome' => 'Camiseta Esportiva',
                'descricao' => 'Camiseta esportiva preta',
                'grupo_produto_id' => 1, // Roupa
                'marca_id' => 5, // Under Armour
                'status' => true,
                'quantidade' => 30,
                'preco' => 39.99
            ],
            [
                'nome' => 'Sapatênis Casual',
                'descricao' => 'Sapatênis casual marrom',
                'grupo_produto_id' => 2, // Calçado
                'marca_id' => 1, // Adidas
                'status' => true,
                'quantidade' => 25,
                'preco' => 89.99
            ],
            [
                'nome' => 'Jaqueta Corta Vento',
                'descricao' => 'Jaqueta corta vento azul',
                'grupo_produto_id' => 1, // Roupa
                'marca_id' => 2, // Nike
                'status' => true,
                'quantidade' => 15,
                'preco' => 129.99
            ],
            [
                'nome' => 'Camiseta Branca',
                'descricao' => 'Camiseta branca básica',
                'grupo_produto_id' => 1, // Roupa
                'marca_id' => 1, // Adidas
                'status' => true,
                'quantidade' => 100,
                'preco' => 29.99
            ],
            [
                'nome' => 'Calça Jeans',
                'descricao' => 'Calça jeans azul',
                'grupo_produto_id' => 1, // Roupa
                'marca_id' => 2, // Nike
                'status' => true,
                'quantidade' => 50,
                'preco' => 59.99
            ],
            [
                'nome' => 'Tênis Esportivo',
                'descricao' => 'Tênis de corrida preto',
                'grupo_produto_id' => 2, // Calçado
                'marca_id' => 3, // Puma
                'status' => true,
                'quantidade' => 30,
                'preco' => 99.99
            ],
            [
                'nome' => 'Jaqueta de Couro',
                'descricao' => 'Jaqueta de couro marrom',
                'grupo_produto_id' => 1, // Roupa
                'marca_id' => 1, // Adidas
                'status' => true,
                'quantidade' => 20,
                'preco' => 199.99
            ],
            [
                'nome' => 'Relógio Analógico',
                'descricao' => 'Relógio de pulso analógico',
                'grupo_produto_id' => 3, // Acessório
                'marca_id' => 4, // Reebok
                'status' => true,
                'quantidade' => 15,
                'preco' => 79.99
            ],
            [
                'nome' => 'Moletom Esportivo',
                'descricao' => 'Moletom esportivo cinza',
                'grupo_produto_id' => 1, // Roupa
                'marca_id' => 3, // Puma
                'status' => true,
                'quantidade' => 60,
                'preco' => 79.99
            ]
        ];

        DB::table('produtos')->insert($produtos);

    }
}
