<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_groupe_enseignants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->cascadeOnDelete();
            $table->foreignId('groupe_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('enseignant_id')->constrained()->cascadeOnDelete();
            $table->unique(['module_id', 'groupe_id', 'enseignant_id'], 'module_groupe_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_groupe_enseignants');
    }
};