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
        Schema::table('seances', function (Blueprint $table) {
            $table->foreign('module_groupe_enseignant_id')
                ->references('id')
                ->on('module_groupe_enseignants')
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('seances', function (Blueprint $table) {
            $table->dropForeign(['module_groupe_enseignant_id']);
        });
    }
};
