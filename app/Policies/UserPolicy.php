<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function view(User $user, User $user2)
    {
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
