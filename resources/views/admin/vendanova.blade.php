@extends('adminlte::page')

@section('title', 'Vendas')

@section('content_header')
    <table class="table">
        <tr>
            <td><h1>Vendas - Nova Venda</h1></td>
            <td align="right">
                <a href="/vendas">
                    <button class="btn btn-success">Voltar</button>
                </a>
            </td>
        </tr>
    </table>
@stop

@section('content')
    @php
    use App\Http\Controllers\UteisController;

    /*
    A variável $situacaoCadastro irá determinar a situação que se encontra a tela:
        Se = 0 Precisa buscar o cliente,
        Se = 1 Cliente localizado, mas não cadastrado
        Se = 2 Cliente localizado e cadastrado
        Se = 3 Editando a venda
    */
    $situacaoCadastro = 0;
    $disabledWhatsapp = "";
    $displayFormVendas = " style=display:none;";
    $disabledNomeEmail = " disabled";
    $javascriptProdutos = "";
    $hdncodigocliente = "";
    if(isset($cliente)){
        $disabledWhatsapp = " disabled";
        $hdncodigocliente = $cliente->id;
        if($cliente->nome==''){
            $situacaoCadastro = 1;
            $disabledNomeEmail = "";
        }
        else {
            $situacaoCadastro = 2;

            $displayFormVendas = '';

            /* Criando a variavel que ira popular o filtro de produtos */
            $javascriptProdutos = 'let listaDeProdutos = ['. PHP_EOL;
            foreach($produtos as $produto){
                $javascriptProdutos .= '{'. PHP_EOL;
                if($produto->imagem) {
                    $javascriptProdutos .= '    "imagem" : "'.$produto->imagem.'",'. PHP_EOL;
                }
                else
                {
                    $javascriptProdutos .= '    "imagem" : "semproduto.png",'. PHP_EOL;
                }
                $javascriptProdutos .= '        "nome" : "'.$produto->nome.'",'. PHP_EOL;
                $javascriptProdutos .= '        "codigo" : '.$produto->id.','. PHP_EOL;
                if($produto->tamanho) {
                    $javascriptProdutos .= '        "tamanho" : "'.$produto->tamanho.'",'. PHP_EOL;
                }
                else
                {
                    $javascriptProdutos .= '        "tamanho" : "OP",'. PHP_EOL;
                }
                $javascriptProdutos .= '        "preco" : '.$produto->precovenda.''. PHP_EOL;
                $javascriptProdutos .= '},'. PHP_EOL;
            }
            $javascriptProdutos .= '];'. PHP_EOL;
            
        }
    }
    @endphp
<div>
    <div class="card card-primary" style="margin-top: -20px;">
        <div class="card-header">
            <h3 class="card-title">Dados de Cliente</h3>
        </div>

        @if($situacaoCadastro==0)

        <form action="{{route('cliente.buscaClientePorWhats')}}" method="POST">

        @elseif($situacaoCadastro==1)

        <form action="{{route('cliente.atualiza', $cliente->id)}}" method="POST">
            

        @endif
            @php
            /*if($situacaoCadastro == 1) {
                echo UteisController::$hiddenMethod;
            }*/

            @endphp

            @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                <label for="exampleInputEmail1">Whatsapp</label>
                <input type="text" required class="form-control" id="whatsapp" name="whatsapp" placeholder="17991919191" value="{{isset($cliente->whatsapp) ? $cliente->whatsapp : ''}}" {{$disabledWhatsapp}}>
                </div>

                <div class="col-6">
                <label for="exampleInputEmail1">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome" value="{{isset($cliente->nome) ? $cliente->nome : ''}}" {{$disabledNomeEmail}}>
                </div>

                <div class="col-4">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email (opcional)" value="{{isset($cliente->email) ? $cliente->email : ''}}" {{$disabledNomeEmail}}>
                </div>
            </div>

        </div>

        <div class="card-footer">
            @if($situacaoCadastro < 2)
        <button type="submit" id="botaopesquisa" name="botaopesquisa" class="btn btn-primary">{{$situacaoCadastro==1 ? 'Salvar' : 'Buscar'}} Cliente</button>
            @endif
        </div>
        @if($situacaoCadastro<=1)
        </form>
        @endif
    </div>
<div {{$displayFormVendas}}>
    <div class="card-body table-responsive p-0">
    <table id="tbProdutos" class="table table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Cor/Tamanho</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
        </table>
    </div>

    <div class="row" style="margin-top: 10px;margin-bottom: 10px;" {{$displayFormVendas}}>
        <div class="col-12 text-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Adicionar Produto
            </button>
        </div>
    </div>
    <form id="frmvenda" name="frmvenda" action="{{route('venda.store')}}" method="POST">
        @csrf

    <input type="hidden" name="hdnCodigosProduto" id="hdnCodigosProduto" value="">
    <input type="hidden" name="hdnStatusPagamento" id="hdnStatusPagamento" value="">

    <input type="hidden" name="hdnCodigoCliente" id="hdnCodigoCliente" value="{{$hdncodigocliente}}">
    <input type="hidden" name="hdnCodigoUsuario" id="hdnCodigoUsuario" value="{{Auth::user()->id}}">

    <input type="hidden" name="hdnvlrpgpixdinheiro" id="hdnvlrpgpixdinheiro" value="">
    <input type="hidden" name="hdntotal" id="hdntotal" value="">
    <ul>
        @foreach($errors->all() as $erro)
        <li>{{$erro}}</li>
        @endforeach
</ul>
    <div class="card card-primary" {{$displayFormVendas}}>
        <div class="card-header">
            <h3 class="card-title">Resumo da Venda</h3>
        </div>
        <div class="row">
        <div class="col-6">
            <table class="table">
                <tr>
                    <td>Valor pagto Pix/Dinheiro:</td>
                    <td><input type="number" required class="form-control" id="vlrpgpixdinheiro" name="vlrpgpixdinheiro" min="0" step="0.01" value="" disabled></td>
                </tr>
                <tr>
                    <td>Valor pagto Débito:</td>
                    <td><input type="number" required class="form-control" id="vlrpgdebito" name="vlrpgdebito" min="0" step="0.01" value="" onkeyup="recalcularItens();"></td>
                </tr>
                <tr>
                    <td>Valor pagto Crédito:</td>
                    <td><input type="number" required class="form-control" id="vlrpgcredito" name="vlrpgcredito" min="0" step="0.01" value=""  onkeyup="recalcularItens();"></td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table">
                <tr>
                    <td>Total:</td>
                    <td><input type="number" required class="form-control" id="total" name="total" min="0" step="0.01" value="" disabled></td>
                </tr>
                <tr>
                    <td>Desconto:</td>
                    <td><input type="number" required class="form-control" id="desconto" name="desconto" min="0" step="0.01" value=""  onkeyup="recalcularItens();"></td>
                </tr>
                <tr>
                    <td>Total com Desconto:</td>
                    <td><input type="number" required class="form-control" id="totalgeral" name="totalgeral" min="0" step="0.01" value="" disabled></td>
                </tr>
            </table>
        </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 20px;" {{$displayFormVendas}}>
        <div class="col-4 text-left">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" onclick="cancelaVenda();">
            Cancelar
            </button>
        </div>
        <div class="col-4 text-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" style="display: none;" onclick="salvarFaturar();">
            Salvar e Aguardar pagamento
            </button>
        </div>
        <div class="col-4 text-right">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" onclick="salvarFaturar('P');">
            Faturar
            </button>
        </div>
    </div>
    </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buscar produto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmProdutosLista" name="frmProdutosLista" method="POST">
            @csrf
            <table>
                <tr>
                    <td>
                        <div id="camposbuscaprodutos" class="row">
                            <div class="col-6">
                                <select class="form-control" name="tipoproduto" onchange="populaProdutos(this.value,'tamanho')">
                                    <option value=""></option>                                                 
                                    <option value="P">T-Shirt P</option> 
                                    <option value="M">T-Shirt M</option>
                                    <option value="G">T-Shirt G</option>
                                    <option value="GG">T-Shirt GG</option>
                                    <option value="G1">T-Shirt G1</option>
                                    <option value="G2">T-Shirt G2</option>
                                    <option value="G3">T-Shirt G3</option>
                                    <option value="XGG">T-Shirt XGG</option>
                                    <option value="OP">Outros Produtos</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control" id="codigoPrd" name="codigoPrd" placeholder="ID Produto" value="" onkeyup="populaProdutos(this.value,'codigo')" >
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="listagemprodutos" class="row">
                            @if(isset($produtos))
                                @foreach($produtos as $produto)
                                <div class="col-3">
                                    <a href="javascript:addLinhaProduto('{{isset($produto->imagem) ? asset('storage/upload/'.$produto->imagem) : asset('storage/upload/semproduto.png')}}','{{$produto->nome}}', '{{$produto->tamanho}}', '{{$produto->precovenda}}', {{$produto->id}});">
                                        <img class="img-fluid pad" src="{{isset($produto->imagem) ? asset('storage/upload/'.$produto->imagem) : asset('storage/upload/semproduto.png')}}" alt="Photo">
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
@stop

@section('css')
<style type="text/css">
    input[type=number]::-webkit-inner-spin-button { 
    -webkit-appearance: none;
    
}
input[type=number] { 
   -moz-appearance: textfield;
   appearance: textfield;

}
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
@stop

@section('js')

<script src="{{ asset('bootstrap\dist\js\bootstrap.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var tb = document.getElementById('tbProdutos');
        var vlrpgpixdinheiro = document.getElementById('vlrpgpixdinheiro');
        var vlrpgdebito = document.getElementById('vlrpgdebito');
        var vlrpgcredito = document.getElementById('vlrpgcredito');
        var total = document.getElementById('total');
        var desconto = document.getElementById('desconto');
        var totalgeral = document.getElementById('totalgeral');
        var listagemprodutos = document.getElementById('listagemprodutos');
        var hdnCodigosProduto = document.getElementById('hdnCodigosProduto');
        var hdnStatusPagamento = document.getElementById('hdnStatusPagamento');
        var frmvenda = document.getElementById('frmvenda');
        var hdnvlrpgpixdinheiro = document.getElementById('hdnvlrpgpixdinheiro');
        var hdntotal = document.getElementById('hdntotal');

        window.onload = function () {
            recalcularItens();
            populaProdutos();
                    }

        function addLinhaProduto(imagem = '', nome = 'padrao', cor = 'Branco', preco = '0,00', codigoProduto = 0){
            var qtdLinhas = tb.rows.length;
            var linha = tb.insertRow(qtdLinhas);

            var cellImagem = linha.insertCell(0);
            var cellNome = linha.insertCell(1);
            var cellCor = linha.insertCell(2);
            var cellPreco = linha.insertCell(3);
            var cellAcao = linha.insertCell(4);

/*
https://www.youtube.com/watch?v=ImkWbhXnISM

https://www.youtube.com/watch?v=s-lT6RZzOGw
*/
            /*if(imagem=='') {
                cellImagem.innerHTML = '<img src="http://127.0.0.1:8000/storage/upload/semproduto.png"  height="100" alt="Photo">';
            }
            else {
                cellImagem.innerHTML = imagem;
            }*/
            if(codigoProduto > 0) {
                hdnCodigosProduto.value = hdnCodigosProduto.value + ';' + codigoProduto + ';';
            }
            cellImagem.innerHTML = '<img src="' + imagem + '" height="100" alt="Photo">';
            cellNome.innerHTML = nome;
            cellCor.innerHTML = cor;
            cellPreco.innerHTML = preco;
            cellAcao.innerHTML = '<button type="button" class="btn btn-danger" onclick="excluirLinhaProduto(' + qtdLinhas + ')">Remover</button>';

            recalcularItens();
        }

        function excluirLinhaProduto(linha){
            if(confirm('Deseja realmente remover este item?')){
                const tbTemp = tb.rows;
                var tamanhoIndice = tbTemp.length;
                var arrImagem = [];
                var arrNome = [];
                var arrCor = [];
                var arrPreco = [];
                var arrCodigo = [];
                var oproprio = true;
                var txtHdnCodProduto = hdnCodigosProduto.value.replaceAll(';;',';');
                var arrCodigoHdn = txtHdnCodProduto.split(';');

                for(i = linha; i < tamanhoIndice; i++)
                {
                    if(!oproprio){
                        trataImg = tbTemp[linha].cells[0].innerHTML;
                        trataImg = trataImg.replace('<img src="', '');
                        trataImg = trataImg.replace('" height="100" alt="Photo">', '');
                        arrImagem.push(trataImg);
                        arrNome.push(tbTemp[linha].cells[1].innerHTML);
                        arrCor.push(tbTemp[linha].cells[2].innerHTML);
                        arrPreco.push(tbTemp[linha].cells[3].innerHTML);
                        arrCodigo.push(arrCodigoHdn[i]);
                    }

                    if(arrCodigoHdn[i]!=''){
                        hdnCodigosProduto.value = hdnCodigosProduto.value.replace(';' + arrCodigoHdn[i] + ';', '');
                    }

                    tb.deleteRow(linha);                   
                    oproprio = false;
                }

                for(j = 0; j < arrNome.length; j++){
                    addLinhaProduto(arrImagem[j], arrNome[j], arrCor[j], arrPreco[j], arrCodigo[j]);
                }

            }
            recalcularItens();
        }

        function cancelaVenda(codVenda = 0){
            if(confirm('Deseja realmente cancelar a venda? Clique em OK para confirmar.')){
                if(codVenda == 0){
                    window.location.href = '{{url("/vendas")}}';
                }
            }
        }

        function salvarFaturar(acao = 'A'){
            if(hdnCodigosProduto.value==''){
                alert('Selecione ao menos um produto.')
                return;
            }
            hdnStatusPagamento.value = acao;
            hdnvlrpgpixdinheiro.value = vlrpgpixdinheiro.value;
            hdntotal.value = total.value;
            frmvenda.submit();
        }

        function recalcularItens(){
            var outrasFormasPagto = 0.00;

            total.value = 0.00;

            if(vlrpgpixdinheiro.value==''){
                vlrpgpixdinheiro.value = 0.00;
            }

            if(vlrpgdebito.value==''){
                vlrpgdebito.value = 0.00;
            }

            if(vlrpgcredito.value==''){
                vlrpgcredito.value = 0.00;
            }

            if(desconto.value==''){
                desconto.value = 0.00;
            }

            for(i = 1; i < tb.rows.length; i++)
            {
                if(tb.rows[i].cells[3]){
                    var cellPreco = tb.rows[i].cells[3];
                    total.value = somaMoeda(total.value, cellPreco.innerHTML);
                }
            }

            outrasFormasPagto = somaMoeda(vlrpgdebito.value, vlrpgcredito.value);

            totalgeral.value = somaMoeda(total.value, desconto.value, '-');

            vlrpgpixdinheiro.value = somaMoeda(totalgeral.value, outrasFormasPagto + '', '-');

        }

        function somaMoeda(valor1, valor2, operacao = '+'){

            valor1 = valor1.replace(',','.');
            valor2 = valor2.replace(',','.');

            var quebraValor1 = valor1.split('.');
            var quebraValor2 = valor2.split('.');
            var soma = 0;
            var retorno = 0.00;       

            valor1 = valor1.replace('.','');
            valor2 = valor2.replace('.','');

            if(quebraValor1.length < 2) {
                valor1 = valor1 + '00';
            }
            else {
                if(quebraValor1[1].length < 2) {
                    valor1 = valor1 + '0';
                }
            }

            if(quebraValor2.length < 2) {
                valor2 = valor2 + '00';
            }
            else {
                if(quebraValor2[1].length < 2) {
                    valor2 = valor2 + '0';
                }
            }

            if(operacao=='-'){
                soma = parseInt(valor1) - parseInt(valor2);
            }          
            else {
                soma = parseInt(valor1) + parseInt(valor2);
            }
            retorno = soma / 100;

            return retorno;
        }

        function populaProdutos(filtro = null, campo = null){

            @php 
            echo $javascriptProdutos; 
            @endphp

            let produtosListar = listaDeProdutos;

            if((campo=='tamanho') && (filtro!='')){
                produtosListar = listaDeProdutos.filter(produtosListar => produtosListar.tamanho == filtro);
            }
            else if((campo=='codigo') && (filtro!=''))
            {
                produtosListar = listaDeProdutos.filter(produtosListar => produtosListar.codigo == filtro);
            }

            var criaDiv = '';

            produtosListar.forEach(function (item,index) {

                criaDiv = criaDiv + '<div class="col-3">';
                criaDiv = criaDiv + '    <a href="javascript:addLinhaProduto(\'{{asset('storage/upload/')}}/' + item['imagem'] + '\',\'' + item['nome'] + '\', \'' + item['tamanho'] + '\', \'' + item['preco'] + '\', ' + item['codigo'] + ');">';
                criaDiv = criaDiv + '        <img class="img-fluid pad" src="{{asset('storage/upload/')}}/' + item['imagem'] + '" alt="Photo">';
                criaDiv = criaDiv + '    </a>';
                criaDiv = criaDiv + '</div>';

            });
            
            listagemprodutos.innerHTML = criaDiv;
        }
    </script>
@stop