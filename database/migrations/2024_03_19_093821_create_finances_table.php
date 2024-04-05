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
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            // cle etrangerer 
            $table->foreignId('utilisateur_id')->constrained(table:'utilisateurs');
            $table->foreignId('bien_id')->constrained(table:'biens');
            $table->foreignId('type_paiement_id')->constrained(table:'type_paiements');
            // $table->foreignId('t')->constrained(table:'type_finances');

    
            $table->string('autrePaiement') ;
            $table->dateTime('datepaiement') ;
            $table->string('montant') ;
            $table->string('statut',100) ;
            $table->string('periode' ,100) ;
            $table->string('commentaire') ;
            $table->string('frequence') ;
            $table->string('slug' ,100) ;
            // a modifier 
            $table->dateTime('delete_id')->nullable() ;   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
