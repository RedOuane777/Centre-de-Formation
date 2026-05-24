<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'reset_code')) {
                $table->string('reset_code')->nullable();
            }

            if (!Schema::hasColumn('users', 'reset_code_expires_at')) {
                $table->timestamp('reset_code_expires_at')->nullable();
            }

            if (!Schema::hasColumn('users', 'reset_attempts')) {
                $table->integer('reset_attempts')->default(0);
            }

            if (!Schema::hasColumn('users', 'reset_token')) {
                $table->string('reset_token', 100)->nullable();
            }

            if (!Schema::hasColumn('users', 'reset_token_expires_at')) {
                $table->timestamp('reset_token_expires_at')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'reset_code',
                'reset_code_expires_at',
                'reset_attempts',
                'reset_token',
                'reset_token_expires_at'
            ]);

        });
    }
};