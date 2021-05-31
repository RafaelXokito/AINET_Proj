<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Cor;
use Barryvdh\Debugbar\Facade as DebugBar;

class CorPolicy
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

    public function create(User $user)
    {
        return false;
    }

    public function store(User $user)
    {
        return false;
    }

    public function edit(User $user)
    {
        return false;
    }

    public function update(User $user)
    {
        return false;
    }

    public function delete(User $user)
    {
        return false;
    }

    public function restore(User $user)
    {
        return false;
    }

    public function forceDelete(User $user)
    {
        return false;
    }
}
