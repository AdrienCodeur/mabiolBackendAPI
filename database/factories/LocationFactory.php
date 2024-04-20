<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'locataire_id'=>rand(1,6),
             'utilisateur_id'=>rand(7,11),
             'contrat_id'=>rand(1,5),
             'slug'=>$this->faker->unique()->slug(2)
        ];
    }
}
