<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Produto::with('grupoProduto')->orderBy('nome', 'asc');

        // Filtrar por grupo_id, se fornecido
        if ($request->has('grupo_id')) {
            $query->where('grupo_produto_id', $request->grupo_id);
        }

          // Filtrar por marca_id, se fornecido
          if ($request->has('marca_id')) {
            $query->where('marca_id', $request->marca_id);
        }

         // Filtrar por marca_id, se fornecido
         if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->all === '0') {
            $produtos = $query->get();
        }else{
            $produtos = $query->paginate(10);
        }

        if ($produtos->isNotEmpty()) {
             $produtos->map(function ($produto) {
                return [
                    'produto' => $produto,
                    'grupo' => $produto->grupoProduto,
                    'marca' => $produto->Marca,

                ];
            });


            return response()->json($produtos);
        }

        return response()->json([
            'message' => 'Nenhuma produto encontrada com os critérios fornecidos.'
        ], 404);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Produto::create($request->all())) {
            return response()->json([
                'message' => 'produto cadastrado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar o produto'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $produto)
    {
        $produto = Produto::find($produto);

        if ($produto) {
            $response = [
                'produto' => $produto,
                'Marca' => $produto->Marca
            ];
            return $response;
        }

        return response()->json([
            'message' => 'Erro ao consultar o cadastro de produtos'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $produto)
    {
        $produto = Produto::find($produto);

        if ($produto) {
            $produto->update($request->all());
            return $produto;
        }

        return response()->json([
            'message' => 'Erro ao atualizar o cadastro de produtos'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $produto)
    {
        if (Produto::destroy($produto)) {
            return response()->json([
                'message' => 'cadastro deletado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao deletar o cadastro de produtos'
        ], 404);

    }
}
