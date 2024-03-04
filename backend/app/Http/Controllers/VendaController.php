<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
    {
        $query = Venda::with('produto');

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
        if ($request->has('agrupar_cliente')) {
            $query->select('pessoa_id', DB::raw('SUM(quantidade) as total_quantidade'), DB::raw('SUM(preco) as total_preco'))
                  ->groupBy('pessoa_id');
        }
        if ($request->has('agrupar_produto')) {
            $query->select('produto_id', DB::raw('SUM(quantidade) as total_quantidade'), DB::raw('SUM(preco) as total_preco'))
                  ->groupBy('produto_id');
        }
        if ($request->has('ord_mes')) {
            $query->orderBy('mes', $request->ord_mes == 1 ? 'asc' : 'desc');// 'asc' para crescente e 'desc' para decrescente
        }
        if ($request->has('media_tempo')) {
            $query->join('compras', 'vendas.produto_id', '=', 'compras.produto_id')
            ->join('produtos', 'compras.produto_id', '=', 'produtos.id')
            ->select('produtos.nome as produto_nome', DB::raw('AVG(EXTRACT(epoch FROM AGE(vendas.data, compras.data)) / 86400) as media_tempo_venda'))
            ->groupBy('produtos.nome')
            ->get();
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

        if ($request->has('agrupar_dia')) {
            $query->select(
                    DB::raw('EXTRACT(YEAR FROM data) as ano'),
                    DB::raw('EXTRACT(MONTH FROM data) as mes'),
                    DB::raw('EXTRACT(DAY FROM data) as dia'),
                    DB::raw('SUM(quantidade) as total_quantidade'),
                    DB::raw('SUM(preco) as total_preco')
                )
                ->groupBy('ano', 'mes', 'dia')
                ->orderBy('ano')
                ->orderBy('mes')
                ->orderBy('dia');
        }



        if ($request->all === '0') {
            $vendas = $query->get();
        }else{
            $vendas = $query->paginate(10);
        }

        if ($vendas->isNotEmpty()) {
            $vendas->map(function ($venda) use ($request) {
                $data = [
                    'venda' => $venda,
                    'produto' => $venda->Produto,
                    'pessoa' => $venda->Pessoa,
                ];

                if ($request->has('agrupar_produto')) {
                    $data['marca'] = $venda->Produto->Marca;
                    $data['grupo'] = $venda->Produto->grupoProduto;
                }

                return $data;
            });

            return response()->json($vendas);
        }

        return response()->json([
            'message' => 'Nenhuma venda encontrada com os critérios fornecidos.'
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Venda::create($request->all())) {
            return response()->json([
                'message' => 'venda cadastrado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar o venda'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $venda)
    {
        $venda = Venda::find($venda);

        if ($venda) {
            $response = [
                'venda' => $venda,
                'pessoa' => $venda->Pessoa,
                'produto' => $venda->Produto

            ];
            return $response;
        }

        return response()->json([
            'message' => 'Erro ao consultar o cadastro de vendas'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $venda)
    {
        $venda = Venda::find($venda);

        if ($venda) {
            $venda->update($request->all());
            return $venda;
        }

        return response()->json([
            'message' => 'Erro ao atualizar o cadastro de vendas'
        ], 404);

    }

    public function atualizarQuantidade($id, Request $request)
    {
        $request->validate([
            'quantidade' => 'required|numeric'
        ]);

        $produto = Produto::findOrFail($id);

        $produto->quantidade -= $request->quantidade;
        $produto->save();

        return response()->json(['message' => 'Quantidade do produto atualizada com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $venda)
    {
        if (Venda::destroy($venda)) {
            return response()->json([
                'message' => 'cadastro deletado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao deletar o cadastro de vendas'
        ], 404);

    }
}
