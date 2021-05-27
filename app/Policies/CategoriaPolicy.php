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
    public function before($user, $ability)
    {
        if ($user->tipo == 'A') {
            return true;
        }
    }


    public function viewAny(User $user)
    {
        return false;
    }

    public function view(User $user, Categoria $categoria)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Categoria $categoria)
    {
        return false;
    }

    public function delete(User $user, Categoria $categoria)
    {
        return false;
    }

    public function restore(User $user, Categoria $categoria)
    {
        //
    }

    public function forceDelete(User $user, Categoria $categoria)
    {
        //
    }
}
