<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrupoProduto;

class GrupoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('produtos')) {
            $grupoProdutoComProdutos = GrupoProduto::with('produtos');
            $grupoProdutos = $grupoProdutoComProdutos->get();

            if ($grupoProdutos->isNotEmpty()) {
                $grupoProdutos->map(function ($grupoProdutos) {
                   return [
                       'produto' => $grupoProdutos->Produto
                   ];
               });
               return response()->json($grupoProdutos);
            };


        }

        return GrupoProduto::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (GrupoProduto::create($request->all())) {
            return response()->json([
                'message' => 'grupo_produto cadastrada com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar a grupo_produtos'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $grupo_produto)
    {
        $grupo_produto = GrupoProduto::find($grupo_produto);

        if ($grupo_produto) {
            return $grupo_produto;
        }

        return response()->json([
            'message' => 'Erro ao consultar o cadastro de grupo_produtos'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $grupo_produto)
    {
        $grupo_produto = GrupoProduto::find($grupo_produto);

        if ($grupo_produto) {
            $grupo_produto->update($request->all());
            return $grupo_produto;
        }

        return response()->json([
            'message' => 'Erro ao atualizar o cadastro de grupo_produtos'
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $grupo_produto)
    {
        if (GrupoProduto::destroy($grupo_produto)) {
            return response()->json([
                'message' => 'cadastro deletado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao atualizar o cadastro de grupo_produtos'
        ], 404);

    }
}
