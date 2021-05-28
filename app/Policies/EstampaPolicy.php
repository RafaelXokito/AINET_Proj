<?php

namespace App\Policies;

use App\Models\Estampa;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EstampaPolicy
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
        return true;
    }

    public function view(User $user, Estampa $estampa)
    {
        if ($estampa->cliente_id == $user->id) {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        if ($user->id > 0) {
            return true;
        }
        return false;
    }

    public function edit(User $user, Estampa $estampa)
    {
        if ($estampa->cliente_id == $user->id) {
            return true;
        }
        return false;
    }

    public function update(User $user, Estampa $estampa)
    {
        if ($estampa->cliente_id == $user->id) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Estampa $estampa)
    {
        return false;
    }

    public function restore(User $user, Estampa $estampa)
    {
        //
    }

    public function forceDelete(User $user, Noticia $noticia)
    {
        //
    }
}
