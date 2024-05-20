<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Abonnee;
use App\Models\Bien;
use App\Models\Contrat;
use App\Models\Finance;
use App\Models\Location;
use App\Models\Proprieter;
use App\Models\Region;
use App\Models\TypeAbonnement;
use App\Models\Utilisateur;
use App\Policies\AbonnementPolicy;
use App\Policies\BienPolicy;
use App\Policies\ContratPolitique;
use App\Policies\FinancePolicy;
use App\Policies\LocationPolitique;
use App\Policies\PropretierPolicy;
use App\Policies\RegionPolicy;
use App\Policies\TypeAbonnementPolicy;
use App\Policies\UtilisateurPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Bien::class => BienPolicy::class ,
        Finance::class => FinancePolicy::class  ,
        Contrat::class => ContratPolitique::class ,
        Location::class => LocationPolitique::class ,
        Abonnee::class => AbonnementPolicy::class ,
        Utilisateur::class =>UtilisateurPolicy::class ,
        Region::class =>RegionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
