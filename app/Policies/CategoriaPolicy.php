<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriaPolicy
{
    use HandlesAuthorization;

    // If user is admin, authorization check always return true
    // Admin user is granted all previleges over "Disciplina" entity
    public function viewAny(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        if ($user->tipo == 'A') {
            return true;
        }
        return false;
    }

    public function store(User $user, Categoria $categoria)
    {
        if ($user->tipo == 'A') {
            return true;
        }
        return false;
    }

    public function edit(User $user, Categoria $categoria)
    {
        if ($user->tipo == 'A') {
            return true;
        }
        return false;
    }

    public function update(User $user, Categoria $categoria)
    {
        if ($user->tipo == 'A') {
            return true;
        }
        return false;
    }

    public function delete(User $user, Categoria $categoria)
    {
        if ($user->tipo == 'A' && Categoria::find($categoria->id)) {
            return true;
        }
        return false;
    }

    public function restore(User $user, Categoria $categoria)
    {
        if ($user->tipo == 'A' && Categoria::onlyTrashed()->find($categoria->id)) {
            return true;
        }
        return false;
    }

    public function forceDelete(User $user, Categoria $categoria)
    {
        //
    }
}
