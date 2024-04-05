<?php

namespace App\Policies;

use App\Models\Bien;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BienPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bien $bien)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user) :bool
    {
        return true ; 
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bien $bien): bool
    {
         return $user->id == $bien->proprietaire_id ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bien $bien): bool
    {
        return $user->id == $bien->proprietaire_id ;
        
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bien $bien)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Bien $bien)
    {
        //
    }
}
