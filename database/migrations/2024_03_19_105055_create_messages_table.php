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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // cle etrangere 
            $table->foreignId('emetteur_id')->constrained(table:'users');
            $table->foreignId('recepteur_id')->constrained(table:'users');
            // a modifier
            $table->dateTime('delete_id')->nullable() ;
            $table->string('contenue') ;
            $table->string('statut') ;
            $table->string('slug') ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('messages');
        
    // }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['recepteur_id']);
            $table->dropColumn('recepteur_id');
            $table->dropForeign(['emetteur_id']);
            $table->dropColumn('emetteur_id');
        });
    }

};
