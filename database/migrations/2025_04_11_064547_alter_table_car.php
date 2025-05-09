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
        schema::table('car', function (Blueprint $table) {
            $table->tinyInteger('tipo')->after('modelo')->nullable(); // Alterado para tinyint
            // $table->string('cor', 15)->after('tipo')->nullable(); // Alterado para varchar(15)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('car', function (Blueprint $table) {
            $table->dropColumn('tipo');
            // $table->dropColumn('cor');
        });
    }
};
