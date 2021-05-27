<?php

namespace App\Policies;

use App\Models\Tshirt;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TshirtPolicy
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

    public function view(User $user, Tshirt $tshirt)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Tshirt $tshirt)
    {
        return false;
    }

    public function delete(User $user, Tshirt $tshirt)
    {
        return false;
    }

    public function restore(User $user, Tshirt $tshirt)
    {
        //
    }

    public function forceDelete(User $user, Tshirt $tshirt)
    {
        //
    }
}
