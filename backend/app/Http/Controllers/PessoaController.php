<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */


 public function index(Request $request)
 {
     $query = Pessoa::with('grupoPessoa')->orderBy('nome', 'asc');

     // Filtrar por grupo_id, se fornecido
     if ($request->has('grupo_id')) {
         $query->where('grupo_pessoa_id', $request->grupo_id);
     }

     // Filtrar por genero, se fornecido
     if ($request->has('genero')) {
         $query->where('genero', $request->genero);
     }

     // Filtrar por nome, se fornecido
     if ($request->has('nome')) {
         $query->where('nome', 'like', '%' . $request->nome . '%');
     }

     // Filtrar por idade, se fornecido
     if ($request->has('idade')) {
         $query->where('idade', $request->idade);
     }

        if ($request->all === '0') {
            $pessoas = $query->get();
        }else{
            $pessoas = $query->paginate(10);
        }

     if ($pessoas->isNotEmpty()) {
          $pessoas->map(function ($pessoa) {
             return [
                 'pessoa' => $pessoa,
                 'grupo' => $pessoa->grupoPessoa,

             ];
         });


         return response()->json($pessoas);
     }

     return response()->json([
         'message' => 'Nenhuma pessoa encontrada com os critérios fornecidos.'
     ], 404);
 }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Pessoa::create($request->all())) {
            return response()->json([
                'message' => 'pessoa cadastrada com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar a pessoas'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $pessoa)
    {

        $pessoa = Pessoa::find($pessoa);

        if ($pessoa) {
            $response = [
                'pessoa' => $pessoa,
                'grupo' => $pessoa->grupoPessoa
            ];
            return $response;
        }

        return response()->json([
            'message' => 'Erro ao consultar o cadastro de pessoas'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $pessoa)
    {
        $pessoa = Pessoa::find($pessoa);

        if ($pessoa) {
            $pessoa->update($request->all());
            return $pessoa;
        }

        return response()->json([
            'message' => 'Erro ao atualizar o cadastro de pessoas'
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $pessoa)
    {
        $pessoa = Pessoa::find($pessoa);
        $pessoa->vendas()->delete(); // Exclui todas as vendas associadas à pessoa
        $pessoa->delete();
        if ($pessoa) {
            return response()->json([
                'message' => 'cadastro deletado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao deletar o cadastro de pessoas'
        ], 404);

    }
}
