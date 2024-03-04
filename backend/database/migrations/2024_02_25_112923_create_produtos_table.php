<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("nome")->nullable();
            $table->string("descricao")->nullable();
            $table->foreignId('grupo_produto_id')->nullable()->constrained()->on('grupo_produtos');
            $table->foreignId('marca_id')->nullable()->constrained()->on('marcas');
            $table->integer("quantidade")->nullable();
            $table->float('preco', 8, 2)->nullable();
            $table->string("status")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function(Blueprint $table){
            $table->foreingId('grupo_produto_id')
            ->on('grupo_produtos')
            ->constrained()
            ->onDelete('cascade');
            $table->foreingId('marca_id')
            ->on('marcas')
            ->constrained()
            ->onDelete('cascade');
        });
    }
};
