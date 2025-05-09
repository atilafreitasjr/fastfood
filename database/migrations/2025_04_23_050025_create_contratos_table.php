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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mensalista_id')->constrained()->onDelete('cascade');
            $table->foreignId('veiculo_id')->constrained()->onDelete('cascade');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->decimal('valor_mensal', 10, 2);
            $table->integer('dia_vencimento'); // Dia de vencimento mensal
            $table->string('status')->default('ativo'); // ativo, suspenso, cancelado
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
