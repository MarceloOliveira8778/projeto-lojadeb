<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_localizacao', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('produto_id')->unsigned();
            $table->bigInteger('localizacao_id')->unsigned();
            $table->integer('quantidade')->unsigned();

            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->foreign('localizacao_id')->references('id')->on('localizacoes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto_localizacao');
    }
};
