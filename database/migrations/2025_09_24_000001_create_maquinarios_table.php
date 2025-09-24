<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('maquinarios', function (Blueprint $table) {
            $table->id('id_maquinario');
            $table->string('maquina', 100);
            $table->string('marca', 50);
            $table->string('modelo', 50);
            $table->unsignedBigInteger('id_fornecedor')->nullable();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->string('supervisor');
            $table->string('cor', 30)->nullable();
            $table->string('patrimonio', 50)->unique();
            $table->decimal('valor', 10, 2)->nullable();
            $table->string('contrato', 50)->nullable();
            $table->string('local', 100)->nullable();
            $table->string('volts', 20)->nullable();
            $table->string('conferencia', 100)->nullable();
            $table->text('observacao')->nullable();
            $table->date('data_saida')->nullable();
            $table->timestamps();

            $table->foreign('id_fornecedor')->references('id_fornecedor')->on('fornecedores')->onDelete('set null');
            $table->foreign('id_cliente')->references('id_cliente')->on('clientes')->onDelete('set null');
            // supervisor será texto, sem relação
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maquinarios');
    }
};
