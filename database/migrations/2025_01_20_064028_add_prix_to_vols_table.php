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
        Schema::table('vols', function (Blueprint $table) {
            $table->decimal('prix', 8, 2)->after('type_avion')->nullable(); // Ajouter la colonne prix
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vols', function (Blueprint $table) {
            //
        });
    }
};
