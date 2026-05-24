<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->foreignId('module_groupe_enseignant_id')
                  ->after('id')
                  ->nullable()
                  ->constrained('module_groupe_enseignants')
                  ->cascadeOnDelete();

            if (Schema::hasColumn('examens', 'module_id')) {
                $table->dropForeign(['module_id']);
                $table->dropColumn('module_id');
            }
            if (Schema::hasColumn('examens', 'groupe_id')) {
                $table->dropForeign(['groupe_id']);
                $table->dropColumn('groupe_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->unsignedBigInteger('module_id')->after('id');
            $table->unsignedBigInteger('groupe_id')->after('module_id');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');

            $table->dropForeign(['module_groupe_enseignant_id']);
            $table->dropColumn('module_groupe_enseignant_id');
        });
    }
};