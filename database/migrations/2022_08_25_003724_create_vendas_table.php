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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('codcliente')->unsigned();
            $table->bigInteger('codusuario')->unsigned();
            $table->decimal('total', 10, 2)->default(0.00);
            $table->decimal('desconto', 10, 2)->default(0.00);
            $table->decimal('vlrpgpixdinheiro', 10, 2)->default(0.00);
            $table->decimal('vlrpgdebito', 10, 2)->default(0.00);
            $table->decimal('vlrpgcredito', 10, 2)->default(0.00);
            $table->string('status', 1)->default('A'); //A - Aguardando pagamento; P - Pago;

            $table->foreign('codcliente')->references('id')->on('clientes')->restrictOnDelete();
            $table->foreign('codusuario')->references('id')->on('users')->restrictOnDelete();

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
        Schema::dropIfExists('vendas');
    }
};
