<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('patients', 'age_unit')) {
            Schema::table('patients', function (Blueprint $table): void {
                $table->string('age_unit', 10)->default('years')->after('age');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('patients', 'age_unit')) {
            Schema::table('patients', function (Blueprint $table): void {
                $table->dropColumn('age_unit');
            });
        }
    }
};