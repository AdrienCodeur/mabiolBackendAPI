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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('email') ;
            $table->string('addresse') ;
            $table->string('login') ;
            $table->string('nom') ;
            $table->string('password') ;
            $table->string('sexe') ;
            $table->string('telephone'); 
            // cle etrangerer 
            // $table->string('typeUserId') ;
            $table->foreignId('type_user')->constrained(table:'type_users');
            $table->enum('statut' ,['actif' ,'inactif']);
            $table->string('slug' ,100)->unique() ;
            // a modifier 
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
