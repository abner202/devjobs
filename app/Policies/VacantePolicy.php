<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vacante;
use Illuminate\Auth\Access\Response;

class VacantePolicy
{
   

    public function viewAny(User $user){

        return $user->rol === 2;
    }


    public function create(User $user){

        return $user->rol === 2;
    }





    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vacante $vacante)
    {
        //
        return $user->id === $vacante->user_id;
    }

}
