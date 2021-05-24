<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TshirtPolicy
{
    use HandlesAuthorization;


    // If user is admin, authorization check always return true
    // Admin user is granted all previleges over "Disciplina" entity
    public function before($user, $ability)
    {
        if ($user->admin) {
            return true;
        }
    }


    public function viewAny(User $user)
    {
        return false;
    }

    public function view(User $user, Noticia $noticia)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Noticia $noticia)
    {
        return false;
    }

    public function delete(User $user, Noticia $noticia)
    {
        return false;
    }

    public function restore(User $user, Noticia $noticia)
    {
        //
    }

    public function forceDelete(User $user, Noticia $noticia)
    {
        //
    }
}
