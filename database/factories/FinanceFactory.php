<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Finance>
 */
class FinanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'utilisateur_id'=>rand(1,4) ,
            'bien_id'=>rand(1,4) ,
            'type_paiement_id'=>rand(1,3) ,
            'autrePaiement'=>$this->faker->sentence(3,true) ,
            'datepaiement'=>$this->faker->dateTime() ,
            'statut'=>$this->faker->sentence(3,true) ,
            'slug'=>$this->faker->slug(3) ,
            'periode'=>$this->faker->sentence(3,true) ,
            'frequence'=>$this->faker->sentence(3,true) ,
            'commentaire'=>$this->faker->sentences(3,true) ,
            'montant'=>$this->faker->numberBetween(200,30000) ,
       ];
    }
}
