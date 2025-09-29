<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('manutencao_maquinario', function (Blueprint $table) {
            $table->id('id_manutencao');
            $table->unsignedBigInteger('maquinario_id');
            $table->date('data_abertura')->nullable();
            $table->text('defeito')->nullable();
            $table->unsignedBigInteger('id_fornecedor')->nullable();
            $table->decimal('orcamento', 10, 2)->nullable();
            $table->decimal('valor_nf', 10, 2)->nullable();
            $table->date('data_vencimento')->nullable();
            $table->timestamps();

            $table->foreign('maquinario_id')->references('id_maquinario')->on('maquinarios')->onDelete('set null');
            $table->foreign('id_fornecedor')->references('id_fornecedor')->on('fornecedores')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manutencao_maquinario');
    }
};
