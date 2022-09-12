@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content_header')
    <table class="table">
        <tr>
            <td><h1>Pedidos</h1></td>
            <td align="right">
                
            </td>
        </tr>
    </table>
@stop

@section('content')
<div>
    @if(session('msg'))
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Mensagem do Sistema</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>

        </div>

        <div class="card-body">
        {{ session('msg') }}
        </div>

    </div>
    @endif
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Adicionar Pedido</h3>
        </div>


        <form class="form-horizontal" action="/pedidos" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Número do Pedido</label>
                    <div class="col-sm-10">
                        <input type="text" required class="form-control" placeholder="Digite o numero do pedido" id="numero" name="numero">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputDataPedido" class="col-sm-2 col-form-label">Data do Pedido</label>
                    <div class="col-sm-10">
                        <input type="date" required class="form-control" placeholder="Digite a data do pedido" id="datapedido" name="datapedido">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Valor Total do Pedido</label>
                    <div class="col-sm-10">
                        <input type="number" required class="form-control" id="totalpedido" name="totalpedido" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Valor do Frete</label>
                    <div class="col-sm-10">
                        <input type="number" required class="form-control" id="valorfrete" name="valorfrete" min="0" step=".01">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Link do Pedido</label>
                    <div class="col-sm-10">
                        <input type="text" required class="form-control" placeholder="Link completo com https://..." id="link" name="link">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info">Salvar Pedido</button>
            </div>

        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pedidos Cadastrados</h3>
        </div>
    
        <div class="card-body">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 200px">Número do Pedido</th>
                    <th style="width: 200px">Data do Pedido</th>
                    <th>Link</th>
                    <th style="width: 100px">Ação</th>
                </tr>
            </thead>

            <tbody>

            @if($pedidos == null)
                <tr>
                    <td colspan="4">Não há pedidos a serem exibidos.</td>
                </tr>
            @endif

            @foreach($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->numero }}</td>
                    <td>{{ $pedido->datapedido }}</td>
                    <td>
                    {{ substr($pedido->link, 0, 80) }}
                    </td>
                    <td>
                        @if($pedido->produtosadd=='N')
                        <a href="/pedidos/{{ $pedido->id }}" class="badge bg-success">Importar Produtos</a>
                        @else 
                            @if($pedido->pedidoconferido=='N')
                            <a href="/pedidoconferir/{{ $pedido->id }}" class="badge bg-info">Conferir Pedido</a>
                            @else
                            <p class="badge bg-alert">Pedido Conferido</p>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                <li class="page-item"><a class="page-link" href="#">«</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">»</a></li>
            </ul>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
    <script> console.log('Hi!'); </script>
@stop