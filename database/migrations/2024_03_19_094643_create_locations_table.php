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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('slug' ,100) ;         
            $table->foreignId('locataire_id')->constrained(table:'utilisateurs');
            $table->foreignId('utilisateur_id')->constrained(table:'utilisateurs');
            $table->unique(['locataire_id' ,'utilisateur_id']) ;
            $table->foreignId('contrat_id')->constrained(table:'contrats');
            $table->dateTime("deleted_at") ->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
