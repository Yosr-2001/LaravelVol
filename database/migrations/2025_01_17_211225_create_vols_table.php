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
        Schema::create('vols', function (Blueprint $table) {
            $table->id();
            $table->string('numero_vol');
            $table->dateTime('heure_depart');
            $table->dateTime('heure_arrivee');
            $table->string('statut')->nullable();
            $table->string('porte')->nullable();
            $table->string('type_avion')->nullable();
            $table->unsignedBigInteger('id_aeroport_depart');
            $table->unsignedBigInteger('id_aeroport_arrivee');

            $table->foreign('id_aeroport_depart')
                ->references('id')
                ->on('aeroports')
                ->onDelete('restrict');

            $table->foreign('id_aeroport_arrivee')
                ->references('id')
                ->on('aeroports')
                ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vols');
    }
};
