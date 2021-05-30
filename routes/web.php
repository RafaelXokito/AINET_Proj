<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\CoresController;
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

Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('/estampas', [EstampasController::class, 'index'])->name('estampas');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->middleware('verified')->group( function () {

    //preços
    Route::get('precos/editar', [PrecosController::class, 'edit'])->name('precos.edit')->middleware('can:edit,App\Models\Preco');
    Route::put('precos/{precos}/update', [PrecosController::class, 'update'])->name('precos.update')->middleware('can:update,App\Models\Preco');

    //estampas
    Route::get('estampas/proprias/{user}', [EstampasController::class, 'index'])->name('estampasUser')->middleware('can:viewTshirtsProprias,user');
    Route::get('estampas/criar', [EstampasController::class, 'create'])->name('estampas.create')->middleware('can:create,App\Models\Estampa');
    Route::post('estampas/store', [EstampasController::class, 'store'])->name('estampas.store')->middleware('can:create,App\Models\Estampa');
    Route::get('estampas/{estampa}/show', [EstampasController::class, 'show'])->name('estampas.show')->middleware('can:view,estampa');
    Route::get('estampas/{estampa}/{cor}/{posicao}/{rotacao}/{opacidade}/preview', [EstampasController::class, 'preview'])->name('estampas.preview')->middleware('can:view,estampa');
    Route::put('estampas/{estampa}/update', [EstampasController::class, 'update'])->name('estampas.update')->middleware('can:update,estampa');
    Route::get('estampas/{estampa}/editar', [EstampasController::class, 'edit'])->name('estampas.edit')->middleware('can:edit,estampa');
    Route::get('estampas/{estampa}/ver', [EstampasController::class, 'edit'])->name('estampas.view')->middleware('can:view,estampa');

    //categorias
    Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias')->middleware('can:isStaff,App\Models\User');
    Route::post('/categorias/store', [CategoriasController::class, 'store'])->name('categorias.store')->middleware('can:store,App\Models\Categoria');
    Route::get('/categorias/{categoria}/update', [CategoriasController::class, 'update'])->name('categorias.update')->middleware('can:update,categoria');
    Route::delete('/categorias/{categoria}/delete', [CategoriasController::class, 'delete'])->name('categorias.delete')->middleware('can:delete,categoria');
    Route::post('/categorias/{categoria}/restore', [CategoriasController::class, 'restore'])->name('categorias.restore'); //->middleware('can:restore,categoria');

    //cores
    Route::get('/cores', [CoresController::class, 'index'])->name('cores')->middleware('can:isStaff,App\Models\User');
    Route::post('/cores/store', [CoresController::class, 'store'])->name('cores.store')->middleware('can:store,App\Models\Cor');
    Route::get('/cores/{cores}/update', [CoresController::class, 'update'])->name('cores.update'); //->middleware('can:update,cor');
    Route::delete('/cores/{cor_codigo}/delete', [CoresController::class, 'delete'])->name('cores.delete'); //->middleware('can:delete,cor');
    Route::post('/cores/{cor_codigo}/restore', [CoresController::class, 'restore'])->name('cores.restore'); //->middleware('can:restore,cor');


    //carrinho de compras
    Route::get('carrinho', [TshirtsController::class, 'carrinho'])->name('carrinho');
    Route::post('carrinho/{estampa}/store_tshirt', [TshirtsController::class, 'store_tshirt'])->name('carrinho.store_tshirt');
    Route::put('carrinho/{tshirt}/update_tshirt', [TshirtsController::class, 'update_tshirt'])->name('carrinho.update_tshirt');
    Route::delete('carrinho/{tshirt}/destroy_tshirt', [TshirtsController::class, 'destroy_tshirt'])->name('carrinho.destroy_tshirt');
    Route::post('carrinho', [TshirtsController::class, 'store'])->name('carrinho.store');
    Route::delete('carrinho', [TshirtsController::class, 'destroy'])->name('carrinho.destroy');

    // admininstração de users
    Route::get('users', [UsersController::class, 'index'])->name('utilizadores')->middleware('can:viewAny,App\Models\User');
    Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('utilizadores.edit')->middleware('can:edit,user');
    Route::get('users/create', [UsersController::class, 'create'])->name('utilizadores.create')->middleware('can:create,App\Models\User');
    Route::post('users', [UsersController::class, 'store'])->name('utilizadores.store')->middleware('can:create,App\Models\User');
    Route::put('users/{user}', [UsersController::class, 'update'])->name('utilizadores.update')->middleware('can:update,user');
    Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('utilizadores.destroy')->middleware('can:delete,user');
    Route::delete('users/{user}/foto', [UsersController::class, 'destroy_foto'])->name('utilizadores.foto.destroy')->middleware('can:update,user');

});

Auth::routes(['register' => true, 'verify' => true]);

