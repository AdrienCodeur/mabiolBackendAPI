<?php

namespace App\Policies;

use App\Models\Finance;
use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Auth\Access\Response;

class FinancePolicy
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
    public function view(User $user, Finance $finance): bool
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
    public function update(Utilisateur $user, Finance $finance): bool
    {
        return   $user->id ===  $finance->utilisateur_id  || $user->login ==="Admin" ;
    }

    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Utilisateur $user, Finance $finance): bool
    {
        return   $user->id ===  $finance->utilisateur_id  || $user->login ==="Admin" ;
    }

    /**
     * Determine whether the user can restore the model.  
     */
    public function restore(User $user, Finance $finance): bool
    {
        return true ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Finance $finance): bool
    {
        return false ;
    }
}
