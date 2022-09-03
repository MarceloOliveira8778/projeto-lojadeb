@extends('adminlte::page')

@section('title', 'Produtos - Cadastrar')

@section('content_header')
    <table class="table">
        <tr>
            <td><h1>Produtos</h1></td>
            <td align="right">
                
            </td>
        </tr>
    </table>
@stop

@section('content')

@php

use App\Http\Controllers\UteisController;

$labels = Array(
    'nome' => '',
    'precocusto' => '',
    'precovenda' => '',
    'imagem' => '',
    'codcor' => 0,
    'tamanho' => '',
    'hiddenmethod' => '',
    'datapedido' => '',
    'acaoformulario' => route('produto.store')
);

if(isset($produto)) {
    $labels['nome'] = $produto->nome;
    $labels['precocusto'] = $produto->precocusto;
    $labels['precovenda'] = $produto->precovenda;
    $labels['imagem'] = $produto->imagem;
    $labels['codcor'] = $produto->codcor;
    $labels['tamanho'] = $produto->tamanho;
    $datapedido = $produto->DataPedido;
    $labels['datapedido'] = $datapedido;
    $labels['hiddenmethod'] = UteisController::$hiddenMethod;
    $labels['acaoformulario'] = route('produto.update', $produto->id);
}

@endphp

<div>
<form action="{{$labels['acaoformulario']}}" method="POST" enctype="multipart/form-data">
    @php
    echo $labels['hiddenmethod'];
    @endphp

    @csrf
<div class="row">
    <div class="col-3">
        <div class="py-1 px-2 mt-3 border text-center">
            <img class="img-fluid pad" src="{{isset($produto->imagem) ? asset('storage/upload/'.$produto->imagem) : asset('storage/upload/semproduto.png')}}" alt="Photo">
        </div>
        <div class="row text-center">
                <input type="file" id="arquivo" name="arquivo">
        </div>
    </div>

    <div class="col-9">
        <div class="row">
            <div class="col-12 mb-3">
                    <label class="text-label">Nome do produto</label><br />
                    <input type="text" required value="{{$labels['nome']}}" name="produto" placeholder="Digite aqui..." class="form-control">
            </div>

            <div class="col-2">
                <label class="text-label">Tamanho</label>
                <select class="form-control" required name="tamanho">
                        <option value=""></option>                                                 
                        <option value="P" {{($labels['tamanho']=='P') ? "selected" : ""}}>P</option> 
                        <option value="M" {{($labels['tamanho']=='M') ? "selected" : ""}}>M</option>
                        <option value="G" {{($labels['tamanho']=='G') ? "selected" : ""}}>G</option>
                        <option value="GG" {{($labels['tamanho']=='GG') ? "selected" : ""}}>GG</option>
                        <option value="G1" {{($labels['tamanho']=='G1') ? "selected" : ""}}>G1</option>
                        <option value="G2" {{($labels['tamanho']=='G2') ? "selected" : ""}}>G2</option>
                        <option value="G3" {{($labels['tamanho']=='G3') ? "selected" : ""}}>G3</option>
                        <option value="XGG" {{($labels['tamanho']=='XGG') ? "selected" : ""}}>XGG</option>
                </select>
            </div>

            <div class="col-4">
                <label class="text-label">Cor</label>
                <select class="form-control" required name="codcor">
                        <option value=""></option> 
                        @foreach($cores as $cor)                                                
                        <option value="{{$cor->id}}"  {{($labels['codcor']==$cor->id) ? "selected" : ""}}>{{$cor->nome}}</option> 
                        @endforeach
                </select>
            </div>
            
            <div class="col-3">
                <label class="text-label">Preço de Custo</label><br />
                <input type="number" required class="form-control" id="precocusto" name="precocusto" min="0" step="0.01" value="{{$labels['precocusto']}}" >
            </div>

            <div class="col-3">
                <label class="text-label">Preço de Venda</label><br />
                <input type="number" required class="form-control" id="precovenda" name="precovenda" min="0" step="0.01" value="{{$labels['precovenda']}}" >
            </div>

            <div class="col-2">
                <label class="text-label">Data do Pedido</label><br />
                <input type="date" required class="form-control" id="datapedido" name="datapedido" value="{{$labels['datapedido']}}" >
            </div>
@can('manage-users')
            <div class="col-10 mt-2 text-right">
                <input type="submit" value="Salvar" class="btn btn-primary">
            </div>
@endcan
        </div>
        
    </div>

</div>
</form>
</div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
    <script> console.log('Hi!'); </script>
@stop