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
        schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('password');
            $table->string('phone')->nullable()->after('photo');
            $table->string('address')->nullable()->after('phone');
            $table->string('role')->default('user')->after('address');
            $table->string('status')->default('1')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('users', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('role');
            $table->dropColumn('status');
        });
    }
};
