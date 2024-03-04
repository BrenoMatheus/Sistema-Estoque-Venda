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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('produto_id')->nullable()->constrained()->on('produtos');
            $table->date('data');
            $table->foreignId('pessoa_id')->nullable()->constrained();
            $table->integer("quantidade")->nullable();
            $table->float("preco", 8, 2)->nullable();

            // $table->usignnedBigInteger('produto_id');
            //$table->foreignId('produto_id')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compras', function(Blueprint $table){
            $table->foreingId('produto_id')
            ->on('produtos')
            ->constrained()
            ->onDelete('cascade');
        });
    }
};
