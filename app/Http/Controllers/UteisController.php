<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UteisController extends Controller
{
    public static $hiddenMethod = '<input name="_method" type="hidden" value="PUT" />';

    public static function preparaValor(String $valueValor) {

        if($valueValor) {
            $valueValor = str_replace('R$','',$valueValor);
            $valueValor = str_replace('.','',$valueValor);
            $valueValor = str_replace(',','.',$valueValor);
        }
        else {
            $valueValor = "0.00";
        }

        return floatval($valueValor);
    }
}
