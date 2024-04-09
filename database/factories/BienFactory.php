<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bien>
 */
class BienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
$images = [];
for ($i = 0; $i < 5; $i++) {
    $images[] = [
        'url' => $this->faker->imageUrl(),
        'alt' => $this->faker->sentence()
    ];
}

        return [
             'nom'=>$this->faker->sentence(4,true) ,
             'surface'=>$this->faker->numberBetween(200,500),
             'addresse'=>$this->faker->address() ,
             'code_postal'=>$this->faker->countryCode() ,
             'nbrbatiment'=>$this->faker->numberBetween(2, 9) ,
             'nbrescalier'=>$this->faker->numberBetween(2, 9) ,
             'nbrchambre'=>$this->faker->numberBetween(2, 9),
             'numeroporte'=>$this->faker->numberBetween(2, 9) ,
             'zoneStationnement'=>$this->faker->numberBetween(2, 9) ,
             'typemouvement'=>$this->faker->sentence(10 ,true) ,
             'ungarage'=>$this->faker->boolean(),
             'ville_id'=>rand(1,5),
             'img'=> json_encode($images),
             'unecave'=>$this->faker->boolean(),
             'internet'=>$this->faker->boolean(),
             'dep_tvecranplat'=>$this->faker->boolean(),
             'dep_lingemaison'=>$this->faker->boolean(),
             'dep_lavevaiselle'=>$this->faker->boolean(),
             'pc_gardiennage'=>$this->faker->boolean(),
             'pc_interphone'=>$this->faker->boolean(),
             'pc_ascenseur'=>$this->faker->boolean(),
             'pc_vide_ordure'=>$this->faker->boolean(),
             'pc_espace_vert'=>$this->faker->boolean(),
             'pc_chauffage_collective'=>$this->faker->boolean(),
             'pc_eau_chaude_collective'=>$this->faker->boolean(),
             'pc_antennetv_collective'=>$this->faker->boolean(),
             'exist_balcon'=>$this->faker->boolean(),
             'exist_cheminee'=>$this->faker->boolean(),
             'exist_salle_manger'=>$this->faker->boolean(),
             'exist_proxi_education'=>$this->faker->boolean(),
             'exist_sous_sol'=>$this->faker->boolean(),
             'exist_proxi_centre_sante'=>$this->faker->boolean(),
             'exist_proxi_restaurant'=>$this->faker->boolean(),
             'anneeconstruction'=>$this->faker->numberBetween(2000 ,2024),
             'nbr_salle_bain'=>$this->faker->boolean(),
             'typeBien_id'=>rand(1,2),
             'statut'=>'actif' ,
             'slug'=>$this->faker->unique()->sentence(3,true),
             'proprietaire_id'=>rand(1,5)

        ];
    }
}
