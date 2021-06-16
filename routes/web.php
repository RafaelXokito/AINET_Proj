<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\CoresController;
use App\Http\Controllers\EncomendasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EstampasController;
use App\Http\Controllers\PrecosController;
use App\Http\Controllers\TshirtsController;
use App\Http\Controllers\UsersController;
use App\Models\Categoria;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/estampas', [EstampasController::class, 'index'])->name('estampas');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('estampas/{estampa}/ver', [EstampasController::class, 'edit'])->name('estampas.view'); //a proteção para as estampas próprias é feita no controllador
Route::get('estampas/{estampa}/{cor}/{posicao}/{rotacao}/{opacidade}/{zoom}/preview', [EstampasController::class, 'preview'])->name('estampas.preview'); //a proteção para as estampas próprias é feita no controllador
Route::get('carrinho', [TshirtsController::class, 'carrinho'])->name('carrinho'); //a proteção para que os staffs não poderem "ter" carrinho é feita no controllador
Route::post('carrinho/{estampa}/store_tshirt', [TshirtsController::class, 'store_tshirt'])->name('carrinho.store_tshirt'); //a proteção para que os staffs não poderem "ter" carrinho é feita no controllador
Route::put('carrinho/{key}/update_tshirt', [TshirtsController::class, 'update_tshirt'])->name('carrinho.update_tshirt');

Route::middleware('auth')->middleware('verified')->group( function () {

    //estatisticas
    Route::middleware('can:isAdmin', App\Models\User::class)->group( function ()
    {
        Route::get('estatisticas', [PageController::class, 'indexEstatisticas'])->name('estatisticas');
        Route::get('estatisticasEncomendasPorMes', [PageController::class, 'indexEstatisticasEncomendasPorMes'])->name('estatisticas');
        Route::get('estatisticasEncomendasPorAno', [PageController::class, 'indexEstatisticasEncomendasPorAno'])->name('estatisticas');
        Route::get('estatisticasCoresMaisUsadas', [PageController::class, 'indexEstatisticasCoresMaisUsadas'])->name('estatisticas');
        Route::get('estatisticasExportar', [PageController::class, 'estatisticasExportar'])->name('estatisticasExportar');
    });



    //preços
    Route::get('precos/editar', [PrecosController::class, 'edit'])->name('precos.edit')->middleware('can:edit,App\Models\Preco');
    Route::put('precos/{precos}/update', [PrecosController::class, 'update'])->name('precos.update')->middleware('can:update,App\Models\Preco');

    //estampas
    Route::get('estampas/proprias/{user}', [EstampasController::class, 'index'])->name('estampasUser')->middleware('can:viewTshirtsProprias,user');
    Route::get('estampas/criar', [EstampasController::class, 'create'])->name('estampas.create')->middleware('can:create,App\Models\Estampa');
    Route::post('estampas/store', [EstampasController::class, 'store'])->name('estampas.store')->middleware('can:create,App\Models\Estampa');
    Route::get('estampas/{estampa}/show', [EstampasController::class, 'show'])->name('estampas.show')->middleware('can:view,estampa');
    Route::put('estampas/{estampa}/update', [EstampasController::class, 'update'])->name('estampas.update')->middleware('can:update,estampa');
    Route::get('estampas/{estampa}/editar', [EstampasController::class, 'edit'])->name('estampas.edit')->middleware('can:edit,estampa');
    Route::delete('/estampas/{estampa}/delete', [EstampasController::class, 'delete'])->name('estampas.delete')->middleware('can:delete,estampa');
    Route::post('/estampas/{id}/restore', [EstampasController::class, 'restore'])->name('estampas.restore'); //não tem middleware pois tem o authorize no controller
    Route::post('/estampas/{id}/forceDelete', [EstampasController::class, 'forceDelete'])->name('estampas.forceDelete'); //não tem middleware pois tem o authorize no controller

    //categorias
    Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias')->middleware('can:isStaff,App\Models\User');
    Route::post('/categorias/store', [CategoriasController::class, 'store'])->name('categorias.store')->middleware('can:store,App\Models\Categoria');
    Route::put('/categorias/{categoria}/update', [CategoriasController::class, 'update'])->name('categorias.update')->middleware('can:update,App\Models\Categoria');
    Route::delete('/categorias/{categoria}/delete', [CategoriasController::class, 'delete'])->name('categorias.delete')->middleware('can:delete,App\Models\Categoria');
    Route::post('/categorias/{id}/restore', [CategoriasController::class, 'restore'])->name('categorias.restore'); //não tem middleware pois tem o authorize no controller
    Route::post('/categorias/{id}/forceDelete', [CategoriasController::class, 'forceDelete'])->name('categorias.forceDelete'); //não tem middleware pois tem o authorize no controller

    //Encomendas
    Route::get('/encomendas', [EncomendasController::class, 'index'])->name('encomendas');
    Route::post('/encomendas/store', [EncomendasController::class, 'store'])->name('encomendas.store')->middleware('can:store,App\Models\Encomenda');
    Route::put('/encomendas/{encomenda}/update', [EncomendasController::class, 'updateEstado'])->name('encomendas.updateEstado')->middleware('can:update,App\Models\Encomenda');
    Route::get('/encomendas/{encomenda}/viewPdf', [EncomendasController::class, 'viewPdf'])->name('encomendas.viewPdf')->middleware('can:viewPdf,encomenda');
    //cores
    Route::get('/cores', [CoresController::class, 'index'])->name('cores')->middleware('can:isStaff,App\Models\User');
    Route::post('/cores/store', [CoresController::class, 'store'])->name('cores.store')->middleware('can:store,App\Models\Cor');
    Route::put('/cores/{cor}/update', [CoresController::class, 'update'])->name('cores.update')->middleware('can:update,App\Models\Cor');
    Route::delete('/cores/{cor}/delete', [CoresController::class, 'delete'])->name('cores.delete')->middleware('can:delete,App\Models\Cor');
    Route::post('/cores/{codigo_cor}/restore', [CoresController::class, 'restore'])->name('cores.restore'); //não tem middleware pois tem o authorize no controller
    Route::post('/cores/{codigo_cor}/forceDelete', [CoresController::class, 'forceDelete'])->name('cores.forceDelete'); //não tem middleware pois tem o authorize no controller

    //carrinho de compras
    Route::delete('carrinho/{key}/destroy_tshirt', [TshirtsController::class, 'destroy_tshirt'])->name('carrinho.destroy_tshirt')->middleware('can:isClient,App\Models\User');
    Route::post('carrinho', [TshirtsController::class, 'store'])->name('carrinho.store')->middleware('can:isClient,App\Models\User');
    Route::delete('carrinho', [TshirtsController::class, 'destroy'])->name('carrinho.destroy')->middleware('can:isClient,App\Models\User');

    //gestão de users
    Route::get('users', [UsersController::class, 'index'])->name('utilizadores')->middleware('can:viewAny,App\Models\User');
    Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('utilizadores.edit')->middleware('can:edit,user');
    Route::get('users/create', [UsersController::class, 'create'])->name('utilizadores.create')->middleware('can:create,App\Models\User');
    Route::post('users', [UsersController::class, 'store'])->name('utilizadores.store')->middleware('can:create,App\Models\User');
    Route::put('users/{user}', [UsersController::class, 'update'])->name('utilizadores.update')->middleware('can:update,user');
    Route::put('users/{user}/bloquear', [UsersController::class, 'updateBloquear'])->name('utilizadores.updateBloquear')->middleware('can:updateBloquear,user');
    Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('utilizadores.destroy')->middleware('can:delete,user');
    Route::delete('users/{user}/foto', [UsersController::class, 'destroy_foto'])->name('utilizadores.foto.destroy')->middleware('can:update,user');
    Route::post('/users/{id}/restore', [UsersController::class, 'restore'])->name('utilizadores.restore'); //não tem middleware pois tem o authorize no controller

});

Auth::routes(['register' => true, 'verify' => true]);

