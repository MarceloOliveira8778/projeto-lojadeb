<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendaRequest;
use App\Models\ItemVenda;
use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendas = Venda::simplepaginate(env('SIS_QTDPAGINAS'));
        return view('admin.vendas', compact('vendas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vendanova');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendaRequest $request)
    {
        $venda = new Venda();
        //codcliente	codusuario	total	desconto	vlrpgpixdinheiro	vlrpgdebito	vlrpgcredito	status
        $venda->codcliente = $request->input('hdnCodigoCliente');
        $venda->codusuario = $request->input('hdnCodigoUsuario');
        $venda->total = $request->input('hdntotal');
        $venda->desconto = $request->input('desconto');
        $venda->vlrpgpixdinheiro = $request->input('hdnvlrpgpixdinheiro');
        $venda->vlrpgdebito = $request->input('vlrpgdebito');
        $venda->vlrpgcredito = $request->input('vlrpgcredito');
        $venda->status = $request->input('hdnStatusPagamento');

        $venda->save();

        $produtosVenda = VendaController::preparaArrayCodigosProduto($request->input('hdnCodigosProduto'));

        foreach($produtosVenda as $produtoVenda)
        {
            $produto = Produto::find($produtoVenda);

            if($produto)
            {
                $item_venda = new ItemVenda();
                //codvenda	codproduto	quantidade	valorunitario
                $item_venda->codvenda = $venda->id;
                $item_venda->codproduto = $produtoVenda;
                $item_venda->quantidade = 1;
                $item_venda->custounitario = $produto->precocusto;
                $item_venda->valorunitario = $produto->precovenda;

                $item_venda->save();

                $produto->quantidade = $produto->quantidade - 1;

                $produto->save();
            }
            //echo('<br>chegou Produto:'.$produtoVenda);
            
        }

        return redirect('/vendas');
        /*echo('<br>chegou hdnCodigosProduto:'.$request->input('hdnCodigosProduto'));
        
        echo('<br>chegou hdnStatusPagamento:'.$request->input('hdnStatusPagamento'));
        echo('<br>chegou hdnCodigoCliente:'.$request->input('hdnCodigoCliente'));
        echo('<br>chegou hdnCodigoUsuario:'.$request->input('hdnCodigoUsuario'));
        echo('<br>chegou hdnvlrpgpixdinheiro:'.$request->input('hdnvlrpgpixdinheiro'));
        echo('<br>chegou vlrpgdebito:'.$request->input('vlrpgdebito'));
        echo('<br>chegou vlrpgcredito:'.$request->input('vlrpgcredito'));
        echo('<br>chegou hdntotal:'.$request->input('hdntotal'));
        echo('<br>chegou desconto:'.$request->input('desconto'));
        exit;*/
    }

    public static function preparaArrayCodigosProduto(String $codigos)
    {
        $codigos = str_replace(';;', '|', $codigos);
        $codigos = str_replace(';', '', $codigos);
        
        $arrRetorno = explode('|', $codigos);

        return $arrRetorno;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
