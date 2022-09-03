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
        Schema::create('item_vendas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('codvenda')->unsigned();
            $table->bigInteger('codproduto')->unsigned();
            $table->integer('quantidade')->default(1);
            $table->decimal('custounitario', 10, 2)->default(0.00);
            $table->decimal('valorunitario', 10, 2)->default(0.00);

            $table->foreign('codvenda')->references('id')->on('vendas')->cascadeOnDelete();
            $table->foreign('codproduto')->references('id')->on('produtos')->restrictOnDelete();

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
        Schema::dropIfExists('item_vendas');
    }
};
