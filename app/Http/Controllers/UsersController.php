<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::select('name', 'email', 'foto_url', 'tipo')->get();
        return view('gestaoUtilizadores.users')->withUsers($users);
    }

    public function admin(Request $request)
    {
        $tipo = $request->tipo ?? '';

        // Use Debugbar to compare both solutions
        // Comment one of the following 2 lines
        $qry = User::query();
        //$qry =  Docente::query();

        if ($tipo) {
            $qry->where('tipo', $tipo);
        }
        $users = $qry->paginate(10);
        return view('gestaoUtilizadores.users')
            ->withUsers($users)
            ->withTipo($tipo);
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
        return redirect()->route('gestaoUtilizadores')
            ->with('alert-msg', 'Utilizador "' . $validated_data['name'] . '" foi criado com sucesso!')
            ->with('alert-type', 'success');
    }
}
