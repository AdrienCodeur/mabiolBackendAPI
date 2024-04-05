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
        Schema::create('abonnees', function (Blueprint $table) {
            $table->id();
            // cle etranger
            // $table->string('utilisateur_id') ;
            $table->foreignId('utilisateur_id')->constrained(table:'utilisateurs');
            $table->foreignId('typeabonnement_id')->constrained(table:'type_abonnements');
            // $table->string('typeabonnement') ;
            // a modifier
            $table->string('statut' ,20);
            $table->string('slug' ,50) ;
           $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnees');
    }
};
