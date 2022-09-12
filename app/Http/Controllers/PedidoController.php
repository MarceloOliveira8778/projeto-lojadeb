<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedido;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $pedidos = Pedido::all();
        return view('admin/pedidos', ['pedidos' => $pedidos]);
    }

    public function store(Request $request)
    {
        $pedido = new Pedido();

        $pedido->numero = $request->numero;
        $pedido->datapedido = $request->datapedido;
        $pedido->link = $request->link;
        $pedido->totalpedido = $request->totalpedido;
        $pedido->valorfrete = $request->valorfrete;

        $pedido->save();

        return redirect("/pedidos")->with('msg', 'Pedido Adicionado com Sucesso!');
    }

    public function importarProduto($id)
    {
        //Abrirá a tela de importação de produtos
        $pedido = Pedido::findOrFail($id);
        return view('admin/pedidosimportarprodutos', ['pedido' => $pedido]);
    }
}
