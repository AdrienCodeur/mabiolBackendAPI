<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        
    $this->call([
        PaysSeeder::class,
    ]);

        \App\Models\Utilisateur::factory(11)->create();
        \App\Models\Ville::factory(5)->create();
        \App\Models\TypeAbonnement::factory(4)->create();
        \App\Models\Abonnee::factory(5)->create();
        \App\Models\Bien::factory(10)->create();
        \App\Models\Contrat::factory(5)->create();
        \App\Models\Finance::factory(5)->create();
        \App\Models\Location::factory(5)->create();


    }
}
