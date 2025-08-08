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
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('categoria'); // cgti, cgpe, aspe, etc.
            $table->string('arquivo_path')->nullable();
            $table->string('arquivo_nome')->nullable();
            $table->integer('arquivo_tamanho')->nullable();
            $table->string('arquivo_tipo')->nullable();
            $table->boolean('ativo')->default(true);
            $table->integer('downloads')->default(0);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processos');
    }
};

