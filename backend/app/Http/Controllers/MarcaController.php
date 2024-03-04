<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('produtos')) {
            $marcaComProdutos = Marca::with('produtos');
            $marcas = $marcaComProdutos->get();

            if ($marcas->isNotEmpty()) {
                $marcas->map(function ($marcas) {
                   return [
                       'produto' => $marcas->Produto
                   ];
               });
               return response()->json($marcas);
            };


        }

        return Marca::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Marca::create($request->all())) {
            return response()->json([
                'message' => 'marca cadastrada com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar a marcas'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $marca)
    {
        $marca = Marca::find($marca);

        if ($marca) {
            return $marca;
        }

        return response()->json([
            'message' => 'Erro ao consultar o cadastro de marcas'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $marca)
    {
        $marca = Marca::find($marca);

        if ($marca) {
            $marca->update($request->all());
            return $marca;
        }

        return response()->json([
            'message' => 'Erro ao atualizar o cadastro de marcas'
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $marca)
    {
        if (Marca::destroy($marca)) {
            return response()->json([
                'message' => 'cadastro deletado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao deletar o cadastro de marcas'
        ], 404);

    }
}
