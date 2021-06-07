<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserPost;
use App\Http\Requests\UserPost;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        $tipo = $request->tipo ?? '';
        $apagado = $request->apagado ?? '';
        // Use Debugbar to compare both solutions
        // Comment one of the following 2 lines
        $qry = User::query();

        if ($apagado == 'deleted') {
            $qry->onlyTrashed();
        } elseif ($apagado == 'all') {
            $qry->withTrashed();
        }
        if ($tipo) {
            $qry->where('tipo', $tipo);
        }

        $users = $qry->paginate(10);

        return view('utilizadores.index')
            ->withUsers($users)
            ->withApagado($apagado)
            ->withTipo($tipo);
    }

    public function edit(User $user)
    {
        $cliente = null;
        if($user->tipo == 'C')
        {
            $cliente = Cliente::find($user->id);
        }
        return view('utilizadores.edit')
            ->withCliente($cliente)
            ->withUser($user);
    }

    public function update(UpdateUserPost $request, User $user)
    {
        $cliente = null;
        $validated_data = $request->validated();
        $user->name = $validated_data['name'];
        if ($user->tipo == 'C') {
            $cliente = Cliente::find($user->id);
            $cliente->nif = $validated_data['nif'];
            $cliente->endereco = $validated_data['endereco'];
            $cliente->tipo_pagamento = $validated_data['tipo_pagamento'];
            $cliente->ref_pagamento = $validated_data['ref_pagamento'];
            $cliente->save();
        }
        if ($user->tipo == 'F' || $user->tipo == 'A') {
            $validated_data = $request->validate([
                'bloqueado' =>    'required',
                'tipo' =>         'required',
            ]);
            $user->tipo = $validated_data['tipo'];
            $user->bloqueado = $validated_data['bloqueado'];
        }
        if ($request->hasFile('foto')) {
            Storage::delete('public/fotos/' . $user->foto_url);
            $path = $request->foto->store('public/fotos');
            $user->foto_url = basename($path);
        }
        $user->save();
        if ($user->tipo == 'F' || $user->tipo == 'A')
        return redirect()->route('utilizadores')
            ->with('alert-msg', 'Utilizador "' . $user->name . '" alterado com sucesso!')
            ->with('alert-type', 'success');
        else
        return redirect()->route('utilizadores.edit', $user)
            ->with('alert-msg', 'Utilizador "' . $user->name . '" alterado com sucesso!')
            ->with('alert-type', 'success')
            ->withCliente($cliente)
            ->withUser($user);

    }

    public function create()
    {
        $newUser = new User;
        return view('utilizadores.create')
            ->withUser($newUser);
    }

    public function store(UserPost $request)
    {
        $validated_data = $request->validated();
        $newUser = new User;
        $newUser->email = $validated_data['email'];
        $newUser->name = $validated_data['name'];
        $newUser->admin = $validated_data['admin'];
        $newUser->tipo = $validated_data['tipo'];
        $newUser->genero = $validated_data['bloqueado'];
        $newUser->password = Hash::make('123');
        if ($request->hasFile('foto')) {
            $path = $request->foto->store('public/fotos');
            $newUser->foto_url = basename($path);
        }
        $newUser->save();
        return redirect()->route('utilizadores')
            ->with('alert-msg', 'Utilizador "' . $validated_data['name'] . '" criado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(User $user)
    {
        $oldName = $user->name;
        $oldUserID = $user->id;
        $oldUrlFoto = $user->foto_url;
        try {
            $user->foto_url = null;
            $user->save();
            if($user->tipo == 'C'){
                Cliente::find($user->id)->delete();
            }
            $user->delete();
            User::destroy($oldUserID);
            Storage::delete('public/fotos/' . $oldUrlFoto);
            return redirect()->route('utilizadores')
                ->with('alert-msg', 'Utilizador "' . $oldName . '" apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('utilizadores')
                    ->with('alert-msg', 'Não foi possível apagar o Utilizador "' . $oldName . '", porque este user está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('utilizadores')
                    ->with('alert-msg', 'Não foi possível apagar o Utilizador "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }
    public function destroy_foto(User $user)
    {
        Storage::delete('public/fotos/' . $user->foto_url);
        $user->foto_url = null;
        $user->save();
        return redirect()->route('gestorUtilizadores.edit', ['user' => $user])
            ->with('alert-msg', 'Foto do user "' . $user->name . '" foi removida!')
            ->with('alert-type', 'success');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $this->authorize('restore', $user);
        try {
            $user->restore();
            return redirect()->route('utilizadores')
                    ->with('alert-msg', 'Utilizador "' . $user->name . '" foi recuperado com sucesso!')
                    ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->route('utilizadores')
                    ->with('alert-msg', 'Não foi possível restaurar o Utilizador "' . $user->name . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
        }
    }

}
