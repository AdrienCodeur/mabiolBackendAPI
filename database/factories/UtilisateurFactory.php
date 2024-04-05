<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Utilisateur>
 */
class UtilisateurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'nom'=>$this->faker->firstName ,
                'addresse'=>$this->faker->address(),
                'email'=>$this->faker->unique()->safeEmail() ,
                'telephone'=>$this->faker->phoneNumber() ,
                'slug'=>$this->faker->unique()->slug(4),
                'statut'=>'actif',
                'login'=>'login',
                'password'=>Hash::make('12345') ,
                'type_user'=>rand(1,2) ,
                'sexe'=>array_rand(['feminum' ,'masculin'] ,1) ,


        ];
    }
}
