<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    //vai ter de sair daqui, os administradores não podem alterar tudo
    //$ability -> assim podemos continuar a usar este método
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

    public function view(User $user, User $user2)
    {
        if ($user->tipo == 'C' && $user2->id == $user->id) {
            return true;
        }elseif ($user->tipo == 'C') {
            return false;
        }
        if($user->tipo == 'F')
        {
            return false;
        }
        if($user->tipo == 'A' && $user2->tipo == 'C')
        {
            return false;
        }elseif($user->tipo == 'A')
        {
            return true;
        }

        return false;
    }

    public function edit(User $user, User $user2)
    {
        if ($user->tipo == 'C' && $user2->id == $user->id) {
            return true;
        }elseif ($user->tipo == 'C') {
            return false;
        }
        if($user->tipo == 'F')
        {
            return false;
        }
        if($user->tipo == 'A' && $user2->tipo == 'C')
        {
            return false;
        }elseif ($user->tipo == 'A') {
            return true;
        }

        return false;

    }

    public function create(User $user)
    {
        return false;
    }

    public function viewTshirtsProprias(User $user, User $user2)
    {
        if ($user2->id == $user->id) {
            return true;
        }
        return false;
    }

    public function update(User $user, User $user2)
    {
        return false;
    }

    public function delete(User $user, User $user2)
    {

        return false;
    }

    public function restore(User $user, User $user2)
    {
        //
    }

    public function forceDelete(User $user, User $user2)
    {
        //
    }
}