<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('estoque', function (Blueprint $table) {
            $table->id('id_estoque');
            $table->unsignedBigInteger('id_produto');
            $table->integer('quantidade')->default(0);

            $table->foreign('id_produto')->references('id_produto')->on('produtos');
            $table->unique('id_produto'); // garante 1 estoque por produto
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estoque');
    }
};
