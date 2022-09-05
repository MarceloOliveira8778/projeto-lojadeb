@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <table class="table">
        <tr>
            <td><h1>Produtos</h1></td>
            <td align="right">
                <a href="/produtoscadastro">
                    <button class="btn btn-success">Cadastrar</button>
                </a>
            </td>
        </tr>
    </table>
@stop

@section('content')
    @php
    use App\Http\Controllers\CorController;
    @endphp
<div>
    <div class="col-20 m-auto">
        <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">Imagem</th>
            <th scope="col">Nome</th>
            <th scope="col">Cor</th>
            <th scope="col">Tamanho</th>
            <th scope="col">Preço de Venda</th>
            <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>
            @if($produtos==null)
            <tr>
                <td colspan="5">Não há produtos cadastrados.</td>
            </tr>
            @endif

            @foreach($produtos as $produto)
                @php
                    $cor = CorController::retornaCor($produto->codcor);
                @endphp
            <tr>
            <th scope="row"><img src="{{$produto->imagem ? asset('storage/app/upload/'.$produto->imagem) : asset('storage/upload/semproduto.png')}}" height="100" /></th>
            <td>{{ $produto->nome }}</td>
            <td>{{ $cor }}</td>
            <td>{{ $produto->tamanho }}</td>
            <td>R$ {{ $produto->precovenda }}</td>
            <td>
                <a href="{{url("produtoscadastro/$produto->id")}}">
                    <button class="btn btn-primary">Editar</button>
                </a>
                <a href="javascript:if(confirm('Deseja realmente excluir?')) {
                                    window.location.href = '{{route('produtos.excluir', $produto->id)}}';
                                }">
                    <button class="btn btn-danger">Excluir</button>
                </a>
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <div class="text-center mt-3 mb-4">
    @php
    $pagination = $produtos->links();
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