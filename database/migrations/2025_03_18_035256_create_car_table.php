<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarTable extends Migration
{
    public function up()
    {
        Schema::create('car', function (Blueprint $table) {
            $table->id();
            $table->string('fabricante');
            $table->string('modelo');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car');
    }
}