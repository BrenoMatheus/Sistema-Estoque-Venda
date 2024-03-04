<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Venda;
use Faker\Factory as Faker;

class VendaTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $produtos = [
            [
                "id" => 1,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Moletom Esportivo",
                "descricao" => "Moletom esportivo cinza",
                "grupo_produto_id" => 1,
                "marca_id" => 3,
                "quantidade" => 60,
                "preco" => "79.99",
                "status" => "1"
            ],
            [
                "id" => 2,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Tênis de Basquete",
                "descricao" => "Tênis de basquete vermelho",
                "grupo_produto_id" => 2,
                "marca_id" => 4,
                "quantidade" => 20,
                "preco" => "149.99",
                "status" => "1"
            ],
            [
                "id" => 3,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Camiseta Esportiva",
                "descricao" => "Camiseta esportiva preta",
                "grupo_produto_id" => 1,
                "marca_id" => 5,
                "quantidade" => 30,
                "preco" => "39.99",
                "status" => "1"
            ],
            [
                "id" => 4,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Sapatênis Casual",
                "descricao" => "Sapatênis casual marrom",
                "grupo_produto_id" => 2,
                "marca_id" => 1,
                "quantidade" => 25,
                "preco" => "89.99",
                "status" => "1"
            ],
            [
                "id" => 5,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Jaqueta Corta Vento",
                "descricao" => "Jaqueta corta vento azul",
                "grupo_produto_id" => 1,
                "marca_id" => 2,
                "quantidade" => 15,
                "preco" => "129.99",
                "status" => "1"
            ],
            [
                "id" => 6,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Camiseta Branca",
                "descricao" => "Camiseta branca básica",
                "grupo_produto_id" => 1,
                "marca_id" => 1,
                "quantidade" => 100,
                "preco" => "29.99",
                "status" => "1"
            ],
            [
                "id" => 7,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Calça Jeans",
                "descricao" => "Calça jeans azul",
                "grupo_produto_id" => 1,
                "marca_id" => 2,
                "quantidade" => 50,
                "preco" => "59.99",
                "status" => "1"
            ],
            [
                "id" => 8,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Tênis Esportivo",
                "descricao" => "Tênis de corrida preto",
                "grupo_produto_id" => 2,
                "marca_id" => 3,
                "quantidade" => 30,
                "preco" => "99.99",
                "status" => "1"
            ],
            [
                "id" => 9,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Jaqueta de Couro",
                "descricao" => "Jaqueta de couro marrom",
                "grupo_produto_id" => 1,
                "marca_id" => 1,
                "quantidade" => 20,
                "preco" => "199.99",
                "status" => "1"
            ],
            [
                "id" => 10,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Relógio Analógico",
                "descricao" => "Relógio de pulso analógico",
                "grupo_produto_id" => 3,
                "marca_id" => 4,
                "quantidade" => 15,
                "preco" => "79.99",
                "status" => "1"
            ],
            [
                "id" => 11,
                "created_at" => null,
                "updated_at" => null,
                "nome" => "Moletom Esportivo",
                "descricao" => "Moletom esportivo cinza",
                "grupo_produto_id" => 1,
                "marca_id" => 3,
                "quantidade" => 60,
                "preco" => "79.99",
                "status" => "1"
            ]
        ];

        // Pessoas IDs de 1 a 7
        $minPessoaId = 1;
        $maxPessoaId = 7;

        for ($i = 0; $i < 100; $i++) {
            $produto = $produtos[array_rand($produtos)];

            $quantidade = $faker->numberBetween(1, $produto['quantidade']);
            $precoTotal = $quantidade * $produto['preco'];

            // Gerar uma data de venda aleatória nos últimos 30 dias
            $dataVenda = $faker->dateTimeBetween('-30 days', 'now');

            // Escolher aleatoriamente uma pessoa ID de 1 a 7
            $pessoaId = $faker->numberBetween($minPessoaId, $maxPessoaId);

            // Criar a venda
            Venda::create([
                'produto_id' => $produto['id'],
                'data' => $dataVenda,
                'pessoa_id' => $pessoaId,
                'quantidade' => $quantidade,
                'preco' => $precoTotal,
            ]);
        }
    }
}
