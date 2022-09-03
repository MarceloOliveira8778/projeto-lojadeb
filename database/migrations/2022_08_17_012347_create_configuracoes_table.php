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
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id();
            $table->decimal('precopadraoP', 10, 2)->default(0.00);
            $table->decimal('precopadraoM', 10, 2)->default(0.00);
            $table->decimal('precopadraoG', 10, 2)->default(0.00);
            $table->decimal('precopadraoGG', 10, 2)->default(0.00);
            $table->decimal('precopadraoG1', 10, 2)->default(0.00);
            $table->decimal('precopadraoG2', 10, 2)->default(0.00);
            $table->decimal('precopadraoG3', 10, 2)->default(0.00);
            $table->decimal('precopadraoXGG', 10, 2)->default(0.00);
            $table->char('tipoGeracaoCusto',1)->default('I'); //M = Média do pedido / I = Item a item
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
        Schema::dropIfExists('configuracoes');
    }
};
