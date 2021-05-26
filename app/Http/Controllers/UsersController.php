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
            ->withUsers($users);
    }
}
