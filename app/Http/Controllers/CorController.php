<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cor;
use Brick\Math\BigInteger;

class CorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function retornaCor(int $codCor) {
        $_cor = Cor::where([
            ['id', '=', $codCor]
        ])->get();
        $retorno = null;
        if(count($_cor)!=0){
            $retorno = $_cor[0]->nome;
        }
        return $retorno;
    }
    // Função que retorna as cores de acordo com o nome
    public static function retornaCores(String $valueCor){
        if($valueCor) {
            $cores = Cor::where([
                ['nome', 'like', $valueCor]
            ])->get();
        }
        else{
            $cores = Cor::all();
        }

        return $cores;
    }

    public static function adicionaSeNaoExiste(String $valueCor)
    {
        $codCor = 0;
        if($valueCor){
            $cores = CorController::retornaCores($valueCor);
            if(count($cores)==0){
                $cor = new Cor();
                $cor->nome = $valueCor;
                $cor->save();

                $codCor = $cor->id;
            }
            else
            {
                $codCor = $cores[0]->id;
            }
        }

        return $codCor;
    }
}
