<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Compra::with('produto');

        // Filtrar por pessoa_id, se fornecido
        if ($request->has('pessoa_id')) {
            $query->where('pessoa_id', $request->pessoa_id);
        }

          // Filtrar por produto_id, se fornecido
          if ($request->has('produto_id')) {
            $query->where('produto_id', $request->produto_id);
        }

        if ($request->has('data') && $request->has('data_fim')) {
            $query->whereBetween('data', [$request->data, $request->data_fim]);
        }

        if ($request->has('data') && !$request->has('data_fim')) {
            $query->whereDate('data', $request->data);
        }

        if ($request->has('ord_data')) {
            $query->orderBy('data', $request->ord_data == 1 ? 'asc' : 'desc');
        }

        if ($request->has('ord_valor')) {
            $query->orderBy('preco', $request->ord_valor == 1 ? 'asc' : 'desc');
        }
        if ($request->has('agrupar_fornecedor')) {
            $query->select('pessoa_id', DB::raw('SUM(quantidade) as total_quantidade'), DB::raw('SUM(preco) as total_preco'))
                  ->groupBy('pessoa_id');
        }
        if ($request->has('ord_mes_valor')) {
            $query->orderBy('total_preco', $request->ord_mes_valor == 1 ? 'asc' : 'desc');// 'asc' para crescente e 'desc' para decrescente
        }

        if ($request->has('agrupar_mes')) {
            $query->select(
                DB::raw('EXTRACT(YEAR FROM data)  as ano'),
                DB::raw('EXTRACT(MONTH FROM data)  as mes'),
                DB::raw('SUM(quantidade) as total_quantidade'),
                DB::raw('SUM(preco) as total_preco')
                )
                ->groupBy('ano', 'mes');
        }

        if ($request->has('ord_mes')) {
            $query->orderBy('mes', $request->ord_mes == 1 ? 'asc' : 'desc');// 'asc' para crescente e 'desc' para decrescente
        }


        if ($request->all === '0') {
            $compras = $query->get();
        }else{
            $compras = $query->paginate(10);
        }

        if ($compras->isNotEmpty()) {
             $compras->map(function ($compra) {
                return [
                    'compra' => $compra,
                    'produto' => $compra->Produto,
                    'pessoa' => $compra->Pessoa,

                ];
            });


            return response()->json($compras);
        }

        return response()->json([
            'message' => 'Nenhuma compra encontrada com os critérios fornecidos.'
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Compra::create($request->all())) {
            return response()->json([
                'message' => 'compra cadastrado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar o compra'
        ], 404);
    }

    public function atualizarQuantidade($id, Request $request)
    {
        $request->validate([
            'quantidade' => 'required|numeric'
        ]);

        $produto = Produto::findOrFail($id);

        $produto->quantidade += $request->quantidade;
        $produto->save();

        return response()->json(['message' => 'Quantidade do produto atualizada com sucesso'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $compra)
    {
        $compra = Compra::find($compra);

        if ($compra) {
            return $compra;
        }

        return response()->json([
            'message' => 'Erro ao consultar o cadastro de compras'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $compra)
    {
        $compra = Compra::find($compra);

        if ($compra) {
            $compra->update($request->all());

            return $compra;
        }

        return response()->json([
            'message' => 'Erro ao atualizar o cadastro de compras'
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $compra)
    {
        if (Compra::destroy($compra)) {
            return response()->json([
                'message' => 'cadastro deletado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao deletar o cadastro de compras'
        ], 404);

    }
}
