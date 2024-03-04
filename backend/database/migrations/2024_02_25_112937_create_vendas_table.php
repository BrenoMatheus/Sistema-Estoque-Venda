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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('produto_id')->nullable()->constrained();
            $table->foreignId('pessoa_id')->nullable()->constrained();
            $table->date('data');
            $table->integer("quantidade")->nullable();
            $table->float("preco", 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendas', function(Blueprint $table){
            $table->foreingId('produto_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreingId('pessoa_id')
            ->constrained()
            ->onDelete('cascade');
        });
    }
};
