<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VilleSeederTwo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Supprime les données existantes de la table 'villes'
        DB::table('villes')->truncate();

        // Insérer des données de test dans la table 'villes'
        $villes = [
            ['nom' => 'Paris', 'pay_id' => 1, 'region_id' => 1],
            ['nom' => 'Marseille', 'pay_id' => 1, 'region_id' => 1],
            ['nom' => 'Lyon', 'pay_id' => 1, 'region_id' => 2],
            // Ajoutez d'autres villes selon vos besoins
        ];

        // Insertion des données dans la table 'villes'
        DB::table('villes')->insert($villes);
    }
}
