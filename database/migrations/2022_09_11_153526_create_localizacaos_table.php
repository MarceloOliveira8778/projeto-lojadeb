<?php

use App\Models\Localizacao;
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
        Schema::create('localizacoes', function (Blueprint $table) {
            $table->id();
            $table->string('localizacao', 50);
            $table->string('ativo', 1)->default('S');
            $table->timestamps();
        });

        $localizacao = new Localizacao();
        $localizacao->localizacao = 'Barretos';
        $localizacao->save();

        $localizacao2 = new Localizacao();
        $localizacao2->localizacao = 'Votuporanga';
        $localizacao2->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localizacoes');
    }
};
