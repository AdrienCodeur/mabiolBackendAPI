<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->string('nom') ;
            $table->string('typemouvement') ;
            $table->integer('nbrchambre');
            $table->string('surface') ;
            $table->string('addresse') ;
            $table->string('code_postal') ;
            $table->foreignId('ville_id')->constrained(table:'villes');
            $table->integer('nbrbatiment') ;
            $table->integer('nbrescalier') ;
            $table->integer('numeroporte') ;
            $table->string('zoneStationnement') ;
            $table->boolean('ungarage') ;
            $table->boolean('unecave') ;
            $table->boolean('internet') ;
            $table->string('dep_tvecranplat') ;
            $table->string('dep_lingemaison') ;
            $table->boolean("dep_lavevaiselle") ;
            $table->boolean("pc_gardiennage") ;
            $table->boolean("pc_interphone") ;
            $table->boolean("pc_ascenseur") ;
            $table->boolean("pc_vide_ordure") ;
            $table->boolean("pc_espace_vert") ;
            $table->boolean("pc_chauffage_collective") ;
            $table->boolean("pc_eau_chaude_collective") ;
            $table->boolean("pc_antennetv_collective") ;
            $table->boolean("exist_balcon") ;
            $table->boolean("exist_cheminee") ;
            $table->boolean("exist_salle_manger") ;
            $table->boolean("exist_proxi_education") ;
            $table->boolean("exist_proxi_centre_sante") ;
            $table->boolean("exist_proxi_restaurant") ;
            $table->boolean("exist_sous_sol") ;
            $table->string('anneeconstruction') ;
            $table->integer("nbr_salle_bain") ;
            $table->json('img') ;
            $table->enum("statut" ,['actif' , 'inactif']) ;
            $table->string("slug" ,100)->unique() ;
            //cle etrangerer 
            $table->foreignId('typeBien_id')->constrained(table:'typebiens');
            $table->foreignId('proprietaire_id')->constrained(table:'utilisateurs');
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
