<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pedidos', [PedidoController::class, 'index']);
Route::get('/pedidoconferir/{id}', [ProdutoController::class, 'conferirPedido']);
Route::post('/pedidos', [PedidoController::class, 'store']);

Route::get('/pedidos/{id}', [PedidoController::class, 'importarProduto']);

Route::get('/produtos', [ProdutoController::class, 'index']);
Route::get('/produtoscadastro', [ProdutoController::class, 'create']);
Route::get('/produtoscadastro/{id}', [ProdutoController::class, 'edit']);
Route::get('/produtos/excluir/{id}', [ProdutoController::class, 'excluir'])->name("produtos.excluir");

Route::get('/vendanova', [VendaController::class, 'create']);
Route::post('/vendanova/cliente/salvar', [VendaController::class, 'store'])->name("venda.store");

Route::post('/vendanova/cliente', [ClienteController::class, 'buscaClientePorWhats'])->name('cliente.buscaClientePorWhats');
Route::post('/vendanova/cliente/{id}', [ClienteController::class, 'update'])->name('cliente.atualiza');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/produto',ProdutoController::class);

Route::resource('/vendas',VendaController::class);
