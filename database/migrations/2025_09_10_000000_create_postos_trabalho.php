<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('postos_trabalho', function (Blueprint $table) {
            $table->id('id_posto');
            $table->string('nome_posto', 100)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postos_trabalho');
    }
};
