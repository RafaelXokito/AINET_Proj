<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::select('name', 'email', 'foto_url', 'tipo')->get();
        return view('utilizadores.users')->withUsers($users);
    }

    public function admin(Request $request)
    {
        $tipo = $request->tipo ?? '';

        // Use Debugbar to compare both solutions
        // Comment one of the following 2 lines
        $qry = User::query();

        if($request->apagado == 'deleted')
        {
            $qry->onlyTrashed();
        }elseif($request->apagado == 'all')
        {
            $qry->withTrashed();
        }

        if ($tipo) {
            $qry->where('tipo', $tipo);
        }
        $users = $qry->paginate(10);
        //dd($users);
        return view('utilizadores.users')
            ->withUsers($users)
            ->withTipo($tipo);
    }

    public function edit(User $user)
    {
        return view('utilizadores.edit')
            ->withUser($user);
    }

    public function update(UserPost $request, User $user)
    {
        $validated_data = $request->validated();
        $user->email = $validated_data['email'];
        $user->name = $validated_data['name'];
        $user->tipo = $validated_data['tipo'];
        $user->bloqueado = $validated_data['bloqueado'];
        if ($request->hasFile('foto')) {
            Storage::delete('public/fotos/' . $user->foto_url);
            $path = $request->foto->store('public/fotos');
            $user->foto_url = basename($path);
        }
        $user->save();
        return redirect()->route('utilizadores')
            ->with('alert-msg', 'User "' . $user->name . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
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
            ->with('alert-msg', 'Utilizador "' . $validated_data['name'] . '" foi criado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(User $user)
    {
        $oldName = $user->name;
        $oldUserID = $user->id;
        $oldUrlFoto = $user->foto_url;
        try {
            $user->delete();
            User::destroy($oldUserID);
            Storage::delete('public/fotos/' . $oldUrlFoto);
            return redirect()->route('utilizadores')
                ->with('alert-msg', 'User "' . $oldName . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('utilizadores')
                    ->with('alert-msg', 'Não foi possível apagar o User "' . $oldName . '", porque este user já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('utilizadores')
                    ->with('alert-msg', 'Não foi possível apagar o User "' . $oldName . '". Erro: ' . $th->errorInfo[2])
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

}
