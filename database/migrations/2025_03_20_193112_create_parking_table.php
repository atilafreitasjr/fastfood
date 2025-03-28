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
        Schema::create('parking', function (Blueprint $table) {
            $table->id();
            $table->foreign('car_id')->references('id')->on('car')->onDelete('restrict');
            $table->string('placa', 7);
            $table->timestamp('data_hora_entrada');
            $table->timestamp('data_hora_saida')->nullable();
            $table->decimal('valor', 8, 2)->nullable();
            $table->tinyInteger('plano')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking');
    }
};
