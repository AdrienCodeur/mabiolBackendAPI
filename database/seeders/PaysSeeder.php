<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     
    //  $pays = [
    //     ['nom' => 'France'],
    //     ['nom' => 'Espagne'],
    //     ['nom' => 'Allemagne'],
        // Ajoutez d'autres pays ici
    // ];

    // Pays::insert($pays);
    public function run(): void
    {
        DB::table('pays')->insert( [
            [
                'nom' => "Cameroun",
            ],
            [
                'nom' => "Tchad",
            ],
            ['nom' => "Gabon"],
            ['nom' => "France"],
            ['nom' => "Russie"] ]
        );
        DB::table('regions')->insert( [
            [
                'nom' => "Littoral", 
                'pay_id'=>1
            ],
            [
                'nom' => "Djamena",
                'pay_id'=>2
            
            ],
            ['nom' => "oyem" ,'pay_id'=>3],
            ['nom' => "paris" ,'pay_id'=>4],
            ['nom' => "Mouscou" ,'pay_id'=>5] ]
        );
        DB::table('type_users')->insert([
            [
                'libelle' => "Proprietaire", 
                'created_at'=>Carbon::now()
            ],
            [
                'libelle' => "Locataire",
                'created_at'=>Carbon::now()
            
            ],
        ]);
        DB::table('typebiens')->insert([
            [
                'libelle' => "neuble", 
            ],
            [
                'libelle' => "location normale",
            
            ],
       ] );
        DB::table('type_echanges')->insert([
            [
                'libelle' => "example de type echanges 1", 
                'slug'=>"example de slug de type echanges 1"
            ],
            [
                'libelle' => "example de type echanges 2", 
                'slug'=>"example de slug de type echanges 2"
            
            ],
            [
                'libelle' => "example de type echanges 3", 
                'slug'=>"example de slug de type echanges 3"
            
            ],
       ] );
 
        DB::table('type_finances')->insert([
            [
                'libelle' => "example de type finances 1", 
                'slug'=>"example de slug de type finances 1"
            ],
            [
                'libelle' => "example de type finances 2", 
                'slug'=>"example de slug de type finances 2"
            ],
            [
                'libelle' => "example de type finances 3", 
                'slug'=>"example de slug de type finances 3"
            
            ],
       ]);
        DB::table('type_paiements')->insert([
            [
                'libelle' => "example de type paiments 1", 
                'slug'=>"example de slug de type paiments 1"
            ],
            [
                'libelle' => "example de type paiments 2", 
                'slug'=>"example de slug de type paiments 2"
            ],
            [
                'libelle' => "example de type paiments 3", 
                'slug'=>"example de slug de type paiments 3"
            
            ],
        ]);
        DB::table('type_contrats')->insert([
            [
                'libelle' => "example de type contrats 1", 
                'slug'=>"example de slug de type contrats 1"
            ],
            [
                'libelle' => "example de type contrats 2", 
                'slug'=>"example de slug de type contrats 2"
            ],
            [
                'libelle' => "example de type contrats 3", 
                'slug'=>"example de slug de type contrats 3"
            
            ],
        ]);
    }
}
