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
        Schema::create('villes', function (Blueprint $table) {
            $table->id();
            $table->string('nom' ,50) ;
            // a modifier 
            $table->dateTime('deleted_at') ->nullable();
            // cle etrangere 
            $table->foreignId('pay_id')->constrained(table:'pays');
            $table->foreignId('region_id')->constrained(table:'regions');
            // $table->string("region_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villes');
    }
};
