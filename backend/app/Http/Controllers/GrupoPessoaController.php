<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrupoPessoa;

class GrupoPessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GrupoPessoa::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (GrupoPessoa::create($request->all())) {
            return response()->json([
                'message' => 'grupo_pessoa cadastrada com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar a grupo_pessoas'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $grupo_pessoa)
    {
        $grupo_pessoa = GrupoPessoa::find($grupo_pessoa);

        if ($grupo_pessoa) {
            return $grupo_pessoa;
        }

        return response()->json([
            'message' => 'Erro ao consultar o cadastro de grupo_pessoas'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $grupo_pessoa)
    {
        $grupo_pessoa = GrupoPessoa::find($grupo_pessoa);

        if ($grupo_pessoa) {
            $grupo_pessoa->update($request->all());
            return $grupo_pessoa;
        }

        return response()->json([
            'message' => 'Erro ao atualizar o cadastro de grupo_pessoas'
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $grupo_pessoa)
    {
        if (GrupoPessoa::destroy($grupo_pessoa)) {
            return response()->json([
                'message' => 'cadastro deletado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao atualizar o cadastro de grupo_pessoas'
        ], 404);

    }
}
