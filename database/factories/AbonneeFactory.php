<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Abonnee>
 */
class AbonneeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'utilisateur_id'=>rand(1,5) ,
            'typeabonnement_id'=>rand(1,3) ,
            'statut'=>'actif' ,
            'slug'=>$this->faker->unique()->slug(3)
        ];
    }
}
