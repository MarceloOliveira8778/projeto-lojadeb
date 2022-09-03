<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Produto;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
        $cliente = Cliente::find($id);

        if(!$cliente) {
            return redirect('/vendas');
        }
        else
        {
            $cliente->nome = $request->input('nome');
            $cliente->email = $request->input('email');

            $cliente->save();

            $produtos = Produto::where('quantidade', '>', '0')->get();

            return view('admin.vendanova', compact('cliente', 'produtos'));
        }
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

    public function buscaClientePorWhats(Request $request)
    {
        $cliente = Cliente::where('whatsapp', $request->input('whatsapp'))->first();

        $produtos = Produto::where('quantidade', '>', '0')->get();
        
        if(!$cliente)
        {
            $cliente = new Cliente();
            $cliente->nome = '';
            $cliente->whatsapp = $request->input('whatsapp');

            $cliente->save();
            echo 'novo';
        }

        return view('admin.vendanova', compact('cliente', 'produtos'));
    }
}
