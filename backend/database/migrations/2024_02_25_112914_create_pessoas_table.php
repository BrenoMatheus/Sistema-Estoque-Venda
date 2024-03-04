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
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("nome")->nullable();
            $table->foreignId('grupo_pessoa_id')->nullable()->constrained()->on('grupo_pessoas');
            $table->string("genero")->nullable();
            $table->integer("idade")->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->on('grupo_pessoas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pessoas', function(Blueprint $table){
            $table->foreingId('grupo_pessoa_id')
            ->on('grupo_pessoas')
            ->constrained()
            ->onDelete('cascade');
        });
    }
};
