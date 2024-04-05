<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contrat>
 */
class ContratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'montantLoyer'=>$this->faker->numberBetween(100 ,400) ,
                'duree'=>$this->faker->numberBetween(1 ,2) ,
                'dateDebut'=>$this->faker->sentence(3,true) ,
                'statut'=>"actif" ,
                'slug'=> $this->faker->unique()->slug(3) ,
                'type_echange_id'=>rand(1,3),
                'type_paiement_id'=>rand(1,3),
                'type_contrat_id'=>rand(1,3) ,
                'locataire_id'=>rand(1,5) ,
                'utilisateur_id'=>rand(6,10) ,
                'close_revision_loyer'=>$this->faker->sentences(3,true) ,
                'indice_reference'=>$this->faker->sentences(3,true) ,
                'description_bail'=>$this->faker->sentences(3,true) ,
                'closeparticuliere'=>$this->faker->sentences(3,true) ,
                'garantsolidaire'=>$this->faker->sentences(3,true) ,
                'aut_paiement'=>$this->faker->sentence(3,true) ,
                'aut_avis_echeance'=>$this->faker->sentence(2,true) ,
                'aut_quittance'=>$this->faker->sentence(2,true) ,
                'charge'=>$this->faker->sentence(4 ,true) ,
        ];
    }
}
