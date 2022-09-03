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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255)->nullable();
            $table->decimal('precocusto', 12, 2)->default(0.00);
            $table->decimal('precovenda', 12, 2)->default(0.00);
            $table->string('imagem', 255)->nullable();
            $table->integer('codcor')->default(0);
            $table->string('tamanho', 5)->nullable();
            $table->string('codigo', 30)->nullable();
            $table->integer('quantidade')->default(0);
            $table->date('DataPedido')->nullable();
            $table->bigInteger('codPedido');
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
        Schema::dropIfExists('produtos');
    }
};
