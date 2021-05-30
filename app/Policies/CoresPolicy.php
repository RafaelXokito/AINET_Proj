<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Cores;

class CoresPolicy
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

    public function store(User $user, Cores $cor)
    {
        if ($user->tipo == 'A') {
            return true;
        }
        return false;
    }

    public function edit(User $user, Cores $cor)
    {
        if ($user->tipo == 'A') {
            return true;
        }
        return false;
    }

    public function update(User $user, Cores $cor)
    {
        if ($user->tipo == 'A') {
            return true;
        }
        return false;
    }

    public function delete(User $user, Cores $cor)
    {
        if ($user->tipo == 'A' && $cor->deleted_at == null) {
            return true;
        }
        return false;
    }

    public function restore(User $user, Cores $cor)
    {
        if ($user->tipo == 'A' && $cor->deleted_at != null) {
            return true;
        }
    }

    public function forceDelete(User $user, Cores $cor)
    {
        //
    }
}
