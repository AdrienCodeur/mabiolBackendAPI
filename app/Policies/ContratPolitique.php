<?php

namespace App\Policies;

use App\Models\Contrat;
use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Auth\Access\Response;

class ContratPolitique
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
    public function view(User $user, Contrat $contrat): bool
    {
         return true ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        
        return true ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Utilisateur $user, Contrat $contrat): bool
    {
         return   $user->id === $contrat->utilisateur_id ||  $user->login === "Admin" ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contrat $contrat): bool
    {
        return   $user->id === $contrat->utilisateur_id  ||  $user->login === "Admin";
        
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Utilisateur $user, Contrat $contrat): bool
    {
         return true ;
    }
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Utilisateur $user, Contrat $contrat): bool
    {
        return false ;
    }
}
