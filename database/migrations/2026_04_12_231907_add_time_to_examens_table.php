<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
        });
    }

    public function down()
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->dropColumn(['heure_debut', 'heure_fin']);
        });
    }
};
