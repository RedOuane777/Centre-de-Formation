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

            $table->dropForeign(['module_id']);
            $table->dropForeign(['groupe_id']);
            $table->dropForeign(['enseignant_id']);

            $table->dropColumn(['module_id', 'groupe_id', 'enseignant_id']);
        });
    }

    public function down()
    {
        Schema::table('seances', function (Blueprint $table) {

            $table->foreignId('module_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('groupe_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('enseignant_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }
};
