<?php

namespace App\Policies;

use App\Models\Region;
use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Auth\Access\Response;

class RegionPolicy
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
    public function view(User $user, Region $region)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Utilisateur $user, Region $region): bool
    {
         return  $user->login == "Admin" ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Utilisateur $user, Region $region): bool
    {
        return  $user->login == "Admin" ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Region $region)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Region $region)
    {
        return  false ;
    }
}
