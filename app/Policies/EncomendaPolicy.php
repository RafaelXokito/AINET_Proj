<?php

namespace App\Policies;

use App\Models\Encomenda;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EncomendaPolicy
{
    use HandlesAuthorization;


    // If user is admin, authorization check always return true
    // Admin user is granted all previleges over "Disciplina" entity
    public function before($user, $ability)
    {
        if ($user->tipo == 'A' && $ability != 'viewPdf') {
            return true;
        }
    }


    public function viewAny(User $user)
    {
        return false;
    }

    public function viewPdf(User $user, Encomenda $encomenda)
    {
        if (( ($user->tipo == 'C' && $encomenda->cliente->user->id == $user->id) || $user->tipo == 'A') && ($encomenda->estado == 'fechada')) {
            return true;
        }
        return false;
    }

    public function view(User $user, Encomenda $encomenda)
    {
        if (($user->tipo == 'C' && $encomenda->cliente->user->id == $user->id) || $user->tipo == 'F') {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        if ($user->tipo == 'C') {
            return true;
        }
        return false;
    }

    public function update(User $user)
    {
        if ($user->tipo == 'A' || $user->tipo == 'F') {
            return true;
        }
        return false;
    }

    public function delete(User $user, Encomenda $encomenda)
    {
        return false;
    }

    public function restore(User $user, Encomenda $encomenda)
    {
        //
    }

    public function forceDelete(User $user, Encomenda $encomenda)
    {
        //
    }
}
