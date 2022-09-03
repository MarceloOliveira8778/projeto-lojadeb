@extends('adminlte::page')

@section('title', 'Vendas')

@section('content_header')
    <table class="table">
        <tr>
            <td><h1>Vendas</h1></td>
            <td align="right">
                <a href="/vendanova">
                    <button class="btn btn-success">Nova Venda</button>
                </a>
            </td>
        </tr>
    </table>
@stop

@section('content')

@php
use App\Models\Cliente;
use App\Models\User;
@endphp

<div>
    <div class="col-20 m-auto">
        <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">Data/Hora</th>
            <th scope="col">Cliente</th>
            <th scope="col">Vendedora</th>
            <th scope="col">Dados da Venda</th>
            <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @if($vendas==null)
            <tr>
                <td colspan="5">Não há vendas cadastradas.</td>
            </tr>
            @endif

            @foreach($vendas as $venda)
                @php
                    $nomeCliente = (Cliente::find($venda->codcliente))->nome;
                    $nomeVendedora = (User::find($venda->codusuario))->name;
                @endphp
            <tr>
            <th scope="row">{{ date("d/m/Y H:i:s", strtotime($venda->created_at))}}</th>
            <td>{{ $nomeCliente }}</td>
            <td>{{ $nomeVendedora }}</td>
            <td>
                Total: R$ {{ $venda->total }}<br />
                Desconto: R$ {{ $venda->desconto }}<br />
                Total com Desconto: R$ {{ ($venda->total - $venda->desconto) }}
            </td>
            <td>Faturada</td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <div class="text-center mt-3 mb-4">
    @php
    $pagination = $vendas->links();
    $pagination = str_replace('Previous', 'Anterior', $pagination);
    $pagination = str_replace('Next', 'Próximo', $pagination);
    echo $pagination;
    @endphp
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
    <script> console.log('Hi!'); </script>
@stop