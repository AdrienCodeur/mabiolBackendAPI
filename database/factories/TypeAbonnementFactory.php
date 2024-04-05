<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeAbonnement>
 */
class TypeAbonnementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
         'nom'=>$this->faker->sentence(10 ,true), 
          'description'=>$this->faker->sentences(3 ,true) ,
         'montant'=>$this->faker->numberBetween(500 ,2000),
         'duree'=>$this->faker->numberBetween(1,2),
         'slug'=>$this->faker-> unique()->slug()
        ];
    }
}
