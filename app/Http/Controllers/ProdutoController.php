<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cor;

use App\Models\Produto;

class ProdutoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $produtos = Produto::simplepaginate(env('SIS_QTDPAGINAS'));
        return view('admin/produtos', ['produtos' => $produtos]);
    }

    public function create(){
        $cores = Cor::all()->sortBy('nome');
        return view('admin.produtoscadastro', ['cores' => $cores]);
    }

    public function store(Request $request)
    {
        $nome_imagem = null;

        if($request->hasFile('arquivo') && $request->file('arquivo')->isValid()){
            $nome_imagem = $request->arquivo->getClientOriginalName();
            $request->arquivo->storeAs('public/upload',$nome_imagem);
        }

        $produto = new Produto();
        $produto->nome = $request->input('produto');
        $produto->codcor = $request->input('codcor');
        $produto->tamanho = $request->input('tamanho');
        $produto->imagem = $nome_imagem;
        $produto->precocusto = $request->input('precocusto');
        $produto->precovenda = $request->input('precovenda');
        $produto->quantidade = 1;
        $produto->datapedido = $request->input('datapedido');
        $produto->codpedido = 0;

        $produto->save();
        return redirect('/produtos');
    }

    public function edit($id){
        $produto = Produto::find($id);
        $cores = Cor::all()->sortBy('nome');
        if(!$produto)
        {
            return redirect('/produtos');
        }
        else
        {
            return view('admin.produtoscadastro', [
                        'produto' => $produto,
                        'cores' => $cores
                    ]);
        }
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);
        if($produto){
            $nome_imagem = $request->input('imagem');

            if($request->hasFile('arquivo') && $request->file('arquivo')->isValid()){
                $nome_imagem = $request->arquivo->getClientOriginalName();
                $request->arquivo->storeAs('public/upload',$nome_imagem);
                $produto->imagem = $nome_imagem;
            }

            $produto->nome = $request->input('produto');
            $produto->codcor = $request->input('codcor');
            $produto->tamanho = $request->input('tamanho');
            $produto->precocusto = $request->input('precocusto');
            $produto->precovenda = $request->input('precovenda');
            $produto->datapedido = ($produto->codpedido==0) ? $request->input('datapedido') : $produto->datapedido;

            $produto->save();
        }
        return redirect('/produtos');
    }

    public function excluir($id){
        $produto = Produto::find($id);
        if($produto){
            $produto->delete();
        }
        return redirect('/produtos');
    }

}
