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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->string("montantLoyer") ;
            // a modofier
            $table->string('duree') ;
            $table->string('dateDebut') ;
            $table->enum('statut' , ['actif' ,'inactif']) ;
            $table->string('slug' ,50)->unique() ;

            $table->string('charge') ;
            // cle etrangerer 
            // $table->string('typeCharge_id') 
            
            $table->foreignId('type_echange_id')->constrained(table:'type_echanges');
            $table->foreignId('type_paiement_id')->constrained(table:'type_paiements');
            $table->foreignId('type_contrat_id')->constrained(table:'type_contrats');
            // $table->foreignId('locataire_id')->constrained(table:'utilisateurs');
            $table->foreignId('utilisateur_id')->constrained(table:'utilisateurs');
            $table->foreignId('locataire_id')->constrained(table:'utilisateurs');
            // $table->foreignId('type_contrat_id')->constrained(table:'type_contrats');
            
            $table->string('close_revision_loyer') ;
            $table->string('indice_reference') ;
            $table->string('description_bail') ;
            $table->string('closeparticuliere') ;
            $table->string('garantsolidaire') ;
            $table->string('aut_paiement') ;
            $table->string('aut_avis_echeance') ;
            $table->string('aut_quittance') ;
            $table->dateTime("deleted_at")->nullable() ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
