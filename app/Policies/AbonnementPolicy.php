<?php

namespace App\Policies;

use App\Models\Abonnee;
use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Auth\Access\Response;

class AbonnementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Abonnee $Abonnee): bool
    {
         return true ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  true ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Abonnee $Abonnee): bool
    {
          return $user->id = $Abonnee->utilisateur_id ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Abonnee $Abonnee): bool
    {
        return $user->id = $Abonnee->utilisateur_id ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Utilisateur $user, Abonnee $Abonnee): bool
    {
        return $user->id = $Abonnee->utilisateur_id ||  $user->login === "Admin" ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Utilisateur $user, Abonnee $Abonnee): bool
    {
        return $user->id = $Abonnee->utilisateur_id  ||  $user->login === "Admin";
    }
}
