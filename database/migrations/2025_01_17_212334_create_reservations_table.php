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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_passager')->constrained('passagers')->onDelete('restrict');
            $table->foreignId('id_vol')->constrained('vols')->onDelete('restrict');
            $table->dateTime('date_reservation');
            $table->string('statut_reservation');
            $table->decimal('prix_reservation', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
