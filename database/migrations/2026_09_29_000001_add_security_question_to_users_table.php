<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'security_question')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->string('security_question')->nullable();
            });
        }

        if (! Schema::hasColumn('users', 'security_answer')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->string('security_answer')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'security_answer')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('security_answer');
            });
        }

        if (Schema::hasColumn('users', 'security_question')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('security_question');
            });
        }
    }
};