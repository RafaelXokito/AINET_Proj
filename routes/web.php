<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EstampasController;
use App\Http\Controllers\PrecosController;
use App\Http\Controllers\UsersController;

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

Route::get('users', [UsersController::class, 'admin'])->name('gestaoUtilizadores');

Route::get('/home', [HomeController::class, 'index'])->name('home');


Auth::routes(['register' => true, 'verify' => true]);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->middleware('verified')->group( function () {

    Route::get('precos/editar', [PrecosController::class, 'edit'])->name('precos.edit')->middleware('can:edit,App\Models\Preco');
    Route::put('precos/{precos}/update', [PrecosController::class, 'update'])->name('precos.update')->middleware('can:update,App\Models\Preco');
    Route::get('estampas/proprias/{user}', [EstampasController::class, 'index'])->name('estampasUser')->middleware('can:viewTshirtsProprias,user');
    Route::get('estampas/criar', [EstampasController::class, 'create'])->name('estampas.create')->middleware('can:create,App\Models\Estampa');

    // admininstração de users
    Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('gestaoUtilizadores.edit')->middleware('can:edit,user');
    Route::get('users/create', [UsersController::class, 'create'])->name('gestaoUtilizadores.create')->middleware('can:create,App\Models\User');
    Route::post('users', [UsersController::class, 'store'])->name('gestaoUtilizadores.store')->middleware('can:create,App\Models\User');
    Route::put('users/{user}', [UsersController::class, 'update'])->name('gestaoUtilizadores.update')->middleware('can:update,user');
    Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('gestaoUtilizadores.destroy')->middleware('can:delete,user');
    Route::delete('users/{user}/foto', [UsersController::class, 'destroy_foto'])->name('gestaoUtilizadores.foto.destroy')->middleware('can:update,user');

});

Auth::routes(['register' => true, 'verify' => true]);

