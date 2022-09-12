@extends('adminlte::page')

@section('title', 'Importar Produtos: Pedido '.$pedido->numero.' - '.$pedido->datapedido)

@section('content_header')
    <h1>Importar Produtos: Pedido {{ $pedido->numero }} - {{ $pedido->datapedido }}</h1>
@stop

@section('content')

    @php
        use App\Models\Produto;
        use App\Http\Controllers\CorController;
        use App\Http\Controllers\UteisController;

        $url = $pedido->link;

        if(str_contains($url, 'ragusostoreatacado.com.br'))
        {
            $htmlSite = file_get_contents($url);

            $var1 = explode('test-id="product-table">',$htmlSite);
            $var2 = explode('</tbody>',$var1[1]);
            $var3 = explode('</tr>',str_replace('<tbody>','', $var2[0]));

            foreach ($var3 as $var) {
                if ($var!='') {
                    $produto = new Produto();

                    $var4 = null;
                    $var4 = explode('</td>',$var);

                    $varDescricao = null;
                    $varSomenteDescricao = null;
                    $varCorTamanhoo = null;
                    $varCor = null;
                    $varTamanho = null;
                    $varDescricao = explode('">',$var4[1]);

                    if(strpos($varDescricao[1], '(')) {
                        $varDescricaoCorTamanho = explode('(',$varDescricao[1]);
                        $varSomenteDescricao = $varDescricaoCorTamanho[0];

                        if(strpos($varDescricaoCorTamanho[1], ', ')) {
                            $varDescricaoCorTamanho[1] = str_replace('.', '', $varDescricaoCorTamanho[1]);
                            $varDescricaoCorTamanho[1] = str_replace(')', '', $varDescricaoCorTamanho[1]);
                            $varDescricaoCorTamanho[1] = str_replace(', ', ' #', $varDescricaoCorTamanho[1]);
                            $varCorTamanhoo = explode('#', $varDescricaoCorTamanho[1]);
                            
                            //$varCor = varCorTamanhoo[0];
                            $varTamanho = substr($varCorTamanhoo[1], 0, strrpos($varCorTamanhoo[1],' × '));
                            $varCor = str_replace("#".$varTamanho,"",$varDescricaoCorTamanho[1]);
                            $varCor = substr($varCor, 0, strrpos($varCor,' × '));
                        }
                    }
                    else 
                    {
                        $varSomenteDescricao = substr($varDescricao[1], 0, strrpos($varDescricao[1],' × '));
                    }
                    /*echo $varSomenteDescricao."<br />\n";
                    echo $varCor." - Cor<br />\n";
                    echo $varTamanho." - Tamanho<br />\n";*/

                    $varPreco = null;
                    $varPreco = explode('">',$var4[2]);
                    /*echo $varPreco[1]."<br />\n";*/

                    $produto->nome = $varSomenteDescricao;
                    $produto->precocusto = UteisController::preparaValor($varPreco[1]);
                    $produto->codcor = CorController::adicionaSeNaoExiste(($varCor == null) ? '' : $varCor);
                    $produto->tamanho = $varTamanho;
                    $produto->quantidade = 1;
                    $produto->datapedido = $pedido->datapedido;
                    $produto->codpedido = $pedido->id;
                    $produto->user_id = Auth::user()->id;
                    $produto->save();

                }	
            }

            $pedido->produtosadd = 'S';
            $pedido->save();

            echo 'Produtos importados com Sucesso!';

        }
        else 
        {
            echo 'Este pedido não pode ser importado. Contate o desenvolvedor.';
        }

    @endphp

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
    <script> console.log('Hi!'); </script>
@stop